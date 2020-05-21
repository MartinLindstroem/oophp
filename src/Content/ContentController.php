<?php
namespace Marty\Content;

use Anax\Commons\AppInjectableInterface;
use Anax\Commons\AppInjectableTrait;

// use Anax\Route\Exception\ForbiddenException;
// use Anax\Route\Exception\NotFoundException;
// use Anax\Route\Exception\InternalErrorException;

/**
 * Controller for dice game
 *
 */
class ContentController implements AppInjectableInterface
{
    use AppInjectableTrait;

    /**
     * This is the index method action, it handles:
     * ANY METHOD mountpoint
     * ANY METHOD mountpoint/
     * ANY METHOD mountpoint/index
     *
     * @return string
     */
    public function indexAction() : object
    {
        $title = "Blogg";
        $content = new Content();
        // Get incoming
        $route = getGet("route", "");

        // General variabels (available to the views)
        $db = $this->app->db;
        $db->connect();
        // $titleExtended = " | My Content Database";
        $content->handleRoute($route, $db);
        $view = $content->getViews();
        $data = $content->getData();
        $title = $content->getTitle();


        // Render the page
        $this->app->page->add("content/header");
        foreach ($view as $value) {
            $this->app->page->add($value, $data);
        }

        return $this->app->page->render([
            "title" => $title,
        ]);
    }
}
