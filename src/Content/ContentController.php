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
        // Deal with the action and return a response.
        // return "index";
        $title = "Blogg";
        $content = new Content();
        // var_dump($content);
        // Get incoming
        $route = getGet("route", "");

        // General variabels (available to the views)
        $db = $this->app->db;
        $db->connect();
        $titleExtended = " | My Content Database";
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



    /**
     * This is the post method action, it handles the
     * post part of the game
     * @return object
     */
    public function playActionPost() : object
    {


        return $this->app->response->redirect("dice1/play");
    }
}
