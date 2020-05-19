<?php

namespace Marty\Content;


class Content
{
    private $view = [];
    private $data = [];
    private $title;

    public function handleRoute($route, $db)
    {
        $slugError = "";
        $filter = new \Marty\TextFilter\MyTextFilter();
        $sql = null;
        $resultset = null;
        // $slugError = "";

        switch ($route) {
            case "":
                $this->title = "Show all content";
                $this->view[] = "content/show-all";
                $sql = "SELECT * FROM content;";
                $resultset = $db->executeFetchAll($sql);
                $this->data["resultset"] = $resultset;
                // var_dump($filter);
                break;

            case "reset":
                $this->title = "Resetting the database";
                $this->view[] = "content/reset";
                $databaseConfig = $db->getOptions();
                $this->data["databaseConfig"] = $databaseConfig;
                break;

            case "admin":
                $this->title = "Admin content";
                $this->view[] = "content/admin";
                $sql = "SELECT * FROM content;";
                $resultset = $db->executeFetchAll($sql);
                $this->data["resultset"] = $resultset;
                break;

            case "edit":
                $this->title = "Edit content";
                $this->view[] = "content/edit";
                $contentId = getPost("contentId") ?: getGet("id");
                // $slugError = "";

                $sql = "SELECT * FROM content;";
                $resultset = $db->executeFetchAll($sql);
                // $this->data["resultset"] = $resultset;
                // var_dump($resultset);


                if (!is_numeric($contentId)) {
                    die("Not valid for content id.");
                }

                if (hasKeyPost("doDelete")) {
                    header("Location: ?route=delete&id=$contentId");
                    exit;
                } elseif (hasKeyPost("doSave")) {
                    $params = getPost([
                        "contentTitle",
                        "contentPath",
                        "contentSlug",
                        "contentData",
                        "contentType",
                        "contentFilter",
                        "contentPublish",
                        "contentId"
                    ]);
                    foreach ($resultset as $res) {
                        if ($params["contentSlug"] == $res->slug) {
                            header("Location: ?route=edit&id=$contentId");
                            $slugError = "ERROR";

                            // $slugError = "Slug is already in use";
                            // echo $slugError;
                            // exit;
                        }
                    }

                    if (!$params["contentSlug"]) {
                        $params["contentSlug"] = slugify($params["contentTitle"]);
                    }

                    if (!$params["contentPath"]) {
                        $params["contentPath"] = null;
                    }

                    if ($params["contentFilter"] == "bbcode") {
                        $params["contentData"] = $filter->bbcode2html($params["contentData"]);
                    }

                    if ($params["contentFilter"] == "markdown") {
                        $params["contentData"] = $filter->markdown($params["contentData"]);
                    }

                    if ($params["contentFilter"] == "link") {
                        $params["contentData"] = $filter->makeClickable($params["contentData"]);
                    }

                    if ($params["contentFilter"] == "nl2br") {
                        $params["contentData"] = $filter->nl2br($params["contentData"]);
                    }



                    $sql = "UPDATE content SET title=?, path=?, slug=?, data=?, type=?, filter=?, published=? WHERE id = ?;";
                    $db->execute($sql, array_values($params));
                    header("Location: ?route=edit&id=$contentId");

                    exit;
                }
                // $slugError = "ERROR";

                $sql = "SELECT * FROM content WHERE id = ?;";
                $content = $db->executeFetch($sql, [$contentId]);
                // var_dump($content);
                $this->data["content"] = $content;
                $this->data["filter"] = $filter;
                $this->data["slugError"] = $slugError;
                break;

            case "create":
                $this->title = "Create content";
                $this->view[] = "content/create";

                if (hasKeyPost("doCreate")) {
                    $this->title = getPost("contentTitle");

                    $sql = "INSERT INTO content (title) VALUES (?);";
                    $db->execute($sql, [$this->title]);
                    $id = $db->lastInsertId();
                    header("Location: ?route=edit&id=$id");
                    exit;
                }
                break;

            case "delete":
                $this->title = "Delete content";
                $this->view[] = "content/delete";
                $contentId = getPost("contentId") ?: getGet("id");
                if (!is_numeric($contentId)) {
                    die("Not valid for content id.");
                }

                if (hasKeyPost("doDelete")) {
                    $contentId = getPost("contentId");
                    $sql = "UPDATE content SET deleted=NOW() WHERE id=?;";
                    $db->execute($sql, [$contentId]);
                    header("Location: ?route=admin");
                    exit;
                }

                $sql = "SELECT id, title FROM content WHERE id = ?;";
                $content = $db->executeFetch($sql, [$contentId]);
                $this->data["content"] = $content;
                break;

            case "pages":
                $this->title = "View pages";
                $this->view[] = "content/pages";

                $sql = <<<EOD
        SELECT
            *,
            CASE
                WHEN (deleted <= NOW()) THEN "isDeleted"
                WHEN (published <= NOW()) THEN "isPublished"
                ELSE "notPublished"
            END AS status
        FROM content
        WHERE type=?
        ;
        EOD;
                $resultset = $db->executeFetchAll($sql, ["page"]);
                $this->data["resultset"] = $resultset;
                break;

            case "blog":
                $this->title = "View blog";
                $this->view[] = "content/blog";

                $sql = <<<EOD
        SELECT
            *,
            DATE_FORMAT(COALESCE(updated, published), '%Y-%m-%dT%TZ') AS published_iso8601,
            DATE_FORMAT(COALESCE(updated, published), '%Y-%m-%d') AS published
        FROM content
        WHERE type=?
        ORDER BY published DESC
        ;
        EOD;
                $resultset = $db->executeFetchAll($sql, ["post"]);
                $this->data["resultset"] = $resultset;
                $this->data["filter"] = $filter;
                break;

            default:
                if (substr($route, 0, 5) === "blog/") {
                    //  Matches blog/slug, display content by slug and type post
                    $sql = <<<EOD
        SELECT
            *,
            DATE_FORMAT(COALESCE(updated, published), '%Y-%m-%dT%TZ') AS published_iso8601,
            DATE_FORMAT(COALESCE(updated, published), '%Y-%m-%d') AS published
        FROM content
        WHERE
            slug = ?
            AND type = ?
            AND (deleted IS NULL OR deleted > NOW())
            AND published <= NOW()
        ORDER BY published DESC
        ;
        EOD;
                    $slug = substr($route, 5);
                    $content = $db->executeFetch($sql, [$slug, "post"]);
                    if (!$content) {
                        header("HTTP/1.0 404 Not Found");
                        $this->title = "404";
                        $this->view[] = "content/404";
                        break;
                    }
                    $this->title = $content->title;
                    $this->data["content"] = $content;
                    $this->view[] = "content/blogpost";
                } else {
                    // Try matching content for type page and its path
                    $sql = <<<EOD
        SELECT
            *,
            DATE_FORMAT(COALESCE(updated, published), '%Y-%m-%dT%TZ') AS modified_iso8601,
            DATE_FORMAT(COALESCE(updated, published), '%Y-%m-%d') AS modified
        FROM content
        WHERE
            path = ?
            AND type = ?
            AND (deleted IS NULL OR deleted > NOW())
            AND published <= NOW()
        ;
        EOD;
                    $content = $db->executeFetch($sql, [$route, "page"]);
                    if (!$content) {
                        header("HTTP/1.0 404 Not Found");
                        $this->title = "404";
                        $this->view[] = "content/404";
                        break;
                    }
                    $this->title = $content->title;
                    $this->data["content"] = $content;
                    $this->view[] = "content/page";
                }
        };
    }

    public function getViews()
    {
        return $this->view;
    }

    public function getData()
    {
        return $this->data;
    }

    public function getTitle()
    {
        return $this->title;
    }

}
