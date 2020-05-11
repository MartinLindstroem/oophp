<?php
/**
 * This will suppress UnusedLocalVariable
 * warnings in this method
 *
 * @SuppressWarnings(PHPMD.CyclomaticComplexity)
 */

namespace Marty\Movie;

use Anax\Commons\AppInjectableInterface;
use Anax\Commons\AppInjectableTrait;

// use Anax\Route\Exception\ForbiddenException;
// use Anax\Route\Exception\NotFoundException;
// use Anax\Route\Exception\InternalErrorException;

/**
 * Controller for movie database
 *
 */
class MovieController implements AppInjectableInterface
{
    use AppInjectableTrait;

    /**
     * This is the index method action, it handles:
     * ANY METHOD mountpoint
     * ANY METHOD mountpoint/
     * ANY METHOD mountpoint/index
     *
     * @return object
     */
     /**
      * This will suppress Cyclomatic complexity
      * warnings in this method
      *
      * @SuppressWarnings(PHPMD.CyclomaticComplexity)
      */
    public function indexActionGet() : object
    {
        $title = "Movie database";
        $route = getGet("route", "");

        $this->app->db->connect();
        $sql = "SELECT * FROM movie;";
        $resultset = $this->app->db->executeFetchAll($sql);

        $data = [];
        $view = [];
        $db = $this->app->db;

        $sql = null;
        $resultset = null;
        // Simple router
        switch ($route) {
            case "":
                $title = "Show all movies";
                $view[] = "index";
                $sql = "SELECT * FROM movie;";
                $resultset = $db->executeFetchAll($sql);
                $data["resultset"] = $resultset;
                break;

            case "select":
                $title = "SELECT *";
                $view[] = "select";
                $sql = "SELECT * FROM movie;";
                $resultset = $db->executeFetchAll($sql);
                $data["resultset"] = $resultset;
                break;

            case "search-title":
                $title = "SELECT * WHERE title";
                $view[] = "search-title";
                $view[] = "index";
                $searchTitle = getGet("searchTitle");
                if ($searchTitle) {
                    $sql = "SELECT * FROM movie WHERE title LIKE ?;";
                    $resultset = $db->executeFetchAll($sql, [$searchTitle]);
                }
                $data["resultset"] = $resultset;
                $data["searchTitle"] = $searchTitle;
                break;

            case "search-year":
                $title = "SELECT * WHERE year";
                $view[] = "search-year";
                $view[] = "index";
                $year1 = getGet("year1");
                $year2 = getGet("year2");
                if ($year1 && $year2) {
                    $sql = "SELECT * FROM movie WHERE year >= ? AND year <= ?;";
                    $resultset = $db->executeFetchAll($sql, [$year1, $year2]);
                } elseif ($year1) {
                    $sql = "SELECT * FROM movie WHERE year >= ?;";
                    $resultset = $db->executeFetchAll($sql, [$year1]);
                } elseif ($year2) {
                    $sql = "SELECT * FROM movie WHERE year <= ?;";
                    $resultset = $db->executeFetchAll($sql, [$year2]);
                }
                $data["year1"] = $year1;
                $data["year2"] = $year2;
                $data["resultset"] = $resultset;
                break;

            case "movie-select":
                $movieId = getPost("movieId");
                $title = "Select a movie";
                $view[] = "movie-select";
                $sql = "SELECT id, title FROM movie;";
                $movies = $db->executeFetchAll($sql);
                $data["movies"] = $movies;
                break;

            case "movie-edit":
                $title = "UPDATE movie";
                $view[] = "movie-edit";
                $movieId    = getPost("movieId") ?: getGet("movieId");

                $sql = "SELECT * FROM movie WHERE id = ?;";
                $movie = $db->executeFetchAll($sql, [$movieId]);
                $movie = $movie[0];
                $data["movie"] = $movie;
                break;
            default:
                ;
        };
        // Render the page
        $this->app->page->add("movie/header");
        foreach ($view as $value) {
            $this->app->page->add("movie/" . $value, $data);
        }
        // $this->app->page->add("guess/debug");
        return $this->app->page->render([
            "title" => $title,
        ]);
    }


    /**
     * This is the post method action, it handles the
     * post part of the CRUD elements.
     * @return object
     */
    public function indexActionPost() : object
    {
        $this->app->db->connect();
        $db = $this->app->db;

        $movieId    = getPost("movieId") ?: getGet("movieId");
        $movieTitle = getPost("movieTitle");
        $movieYear  = getPost("movieYear");
        $movieImage = getPost("movieImage");

        if (getPost("doDelete")) {
            $sql = "DELETE FROM movie WHERE id = ?;";
            $db->execute($sql, [$movieId]);
            $this->app->response->redirect("?route=movie-select");
            // header("Location: ?route=movie-select");
            // exit;
        } elseif (getPost("doAdd")) {
            $sql = "INSERT INTO movie (title, year, image) VALUES (?, ?, ?);";
            $db->execute($sql, ["A title", 2017, "img/noimage.png"]);
            $movieId = $db->lastInsertId();
            $this->app->response->redirect("?route=movie-edit&movieId=$movieId");
            // header("Location: ?route=movie-edit&movieId=$movieId");
            // exit;
        } elseif (getPost("doEdit") && is_numeric($movieId)) {
            $this->app->response->redirect("?route=movie-edit&movieId=$movieId");
            // header("Location: ?route=movie-edit&movieId=$movieId");
            // exit;
        }

        if (getPost("doSave")) {
            $sql = "UPDATE movie SET title = ?, year = ?, image = ? WHERE id = ?;";
            $db->execute($sql, [$movieTitle, $movieYear, $movieImage, $movieId]);
            $this->app->response->redirect("?route=movie-edit&movieId=$movieId");
            // header("Location: ?route=movie-edit&movieId=$movieId");
            // exit;
        }
    }
}
