<?php
/**
 * Create routes using $app programming style.
 */
//var_dump(array_keys(get_defined_vars()));



/**
 * Init the game and redirect to play
 */
$app->router->get("dice/init", function () use ($app) {
    // Init the session for the game

    $diceGame = new Marty\Dice\DiceGame();
    $_SESSION["DiceGame"] = $diceGame;
    $_SESSION["activePlayer"] = "player";

    $activePlayer = $_SESSION["activePlayer"] ?? null;

    $_SESSION["roll"] = null;
    $_SESSION["sim"] = null;

    return $app->response->redirect("dice/play");
});


/**
 * Play the game - show the game status
 */
$app->router->get("dice/play", function () use ($app) {
    $title = "Tärning 100!";

    $diceGame = $_SESSION["DiceGame"];
    $value = $_SESSION["value"] ?? null;
    $roll = $_SESSION["roll"] ?? null;
    $sim = $_SESSION["sim"] ?? null;
    $activePlayer = $_SESSION["activePlayer"] ?? null;

    $playerTotal = $diceGame->player->getTotalScore();
    $playerCurrent = $diceGame->player->getCurrentScore();

    $computerTotal = $diceGame->computer->getTotalScore();



    $data = [
        "diceGame" => $diceGame,
        "value" => $value ?? null,
        "playerCurrent" => $playerCurrent ?? null,
        "playerTotal" => $playerTotal ?? null,
        "computerTotal" => $computerTotal ?? null,
        "roll" => $roll ?? null,
        "activePlayer" => $activePlayer ?? null,
        "sim" => $sim ?? null
    ];

    $app->page->add("dice/play", $data);
    // $app->page->add("guess/debug");

    return $app->page->render([
        "title" => $title,
    ]);
});


$app->router->post("dice/play", function () use ($app) {
    $activePlayer = $_SESSION["activePlayer"] ?? null;
    $_SESSION["roll"] = $_POST["roll"] ?? null;
    $_SESSION["sim"] = $_POST["sim"] ?? null;

    $diceGame = $_SESSION["DiceGame"];
    $roll = $_POST["roll"] ?? null;
    $hold = $_POST["hold"] ?? null;
    $sim = $_POST["sim"] ?? null;
    $restart = $_POST["restart"] ?? null;


    if ($roll) {
        $diceGame->rollDice($activePlayer);
        $_SESSION["value"] = $diceGame->$activePlayer->dice->getNumber();

        if ($_SESSION["value"] == 1 && $activePlayer == "player") {
            $_SESSION["activePlayer"] = "computer";
        } elseif ($_SESSION["value"] == 1 && $activePlayer == "computer") {
            $_SESSION["activePlayer"] = "player";
        }
    }

    if ($hold) {
        $diceGame->$activePlayer->hold();
        $_SESSION["activePlayer"] = "computer";
    }

    if ($sim) {
        $diceGame->simComputer();
        $diceGame->$activePlayer->hold();
        $_SESSION["activePlayer"] = "player";
    }

    if ($restart) {
        $diceGame = new Marty\Dice\DiceGame();
        $_SESSION["DiceGame"] = $diceGame;
        $_SESSION["activePlayer"] = "player";

        $activePlayer = $_SESSION["activePlayer"] ?? null;

        $_SESSION["roll"] = null;
        $_SESSION["sim"] = null;
    }

    return $app->response->redirect("dice/play");
});
