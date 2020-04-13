<?php
/**
 * Create routes using $app programming style.
 */
//var_dump(array_keys(get_defined_vars()));



/**
 * Init the game and redirect to play
 */
$app->router->get("guess/init", function () use ($app) {
    // Init the session for the game

    $game = new Marty\Guess\Guess();
    $game->random();
    $_SESSION["number"] = $game->number();
    $_SESSION["tries"] = $game->tries();

    return $app->response->redirect("guess/play");
});



/**
 * Play the game - show the game status
 */
$app->router->get("guess/play", function () use ($app) {
    $title = "Gissa numret!";

    $number = $_SESSION["number"];
    $tries = $_SESSION["tries"] ?? null;
    $guess = $_SESSION["guess"] ?? null;
    $res = $_SESSION["res"] ?? null;
    $cheat = $_SESSION["cheat"] ?? null;
    $_SESSION["res"] = null;
    $_SESSION["cheat"] = null;


    $data = [
        "number" => $number,
        "tries" => $tries,
        "guess" => $guess ?? null,
        "doGuess" => $doGuess ?? null,
        "doCheat" => $doCheat ?? null,
        "res" => $res,
        "cheat" => $cheat
    ];

    $app->page->add("guess/play", $data);
    // $app->page->add("guess/debug");

    return $app->page->render([
        "title" => $title,
    ]);
});


/**
 * Play the game - make a guess
 */
$app->router->post("guess/play", function () use ($app) {

    $guess = $_POST["guess"] ?? null;
    $doGuess = $_POST["doGuess"] ?? null;
    $doInit = $_POST["doInit"] ?? null;
    $doCheat = $_POST["doCheat"] ?? null;

    $number = $_SESSION["number"] ?? null;
    $tries = $_SESSION["tries"] ?? null;

    if ($doGuess) {
        $game = new Marty\Guess\Guess($number, $tries);
        $res = $game->makeGuess($guess);
        $_SESSION["res"] = $res;
        $_SESSION["tries"] = $game->tries();
        $_SESSION["res"] = $res;
        $_SESSION["guess"] = $guess;
    }
    if ($doCheat) {
        $cheat = "cheat";
        $_SESSION["cheat"] = $cheat;
    }
    if ($doInit) {
        $game = new Marty\Guess\Guess();
        $game->random();
        $_SESSION["number"] = $game->number();
        $_SESSION["tries"] = $game->tries();
    }

    return $app->response->redirect("guess/play");
});
