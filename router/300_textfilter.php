<?php
namespace Marty\TextFilter;

/**
 * Create routes using $app programming style.
 */



/**
 * Init the game and redirect to play
 */
$app->router->get("textfilter", function () use ($app) {
    $title = "Textfilter";

    // $filter = new Marty\TextFilter\MyTextFilter();
    $filter = new MyTextFilter();



    $data = [
        "filter" => $filter
    ];

    $app->page->add("textfilter/index", $data);
    // $app->page->add("guess/debug");

    return $app->page->render([
        "title" => $title,
    ]);
});
