<?php

namespace Marty\Dice;

use Anax\Commons\AppInjectableInterface;
use Anax\Commons\AppInjectableTrait;

// use Anax\Route\Exception\ForbiddenException;
// use Anax\Route\Exception\NotFoundException;
// use Anax\Route\Exception\InternalErrorException;

/**
 * Controller for dice game
 *
 */
class DiceController implements AppInjectableInterface
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
    public function indexAction() : string
    {
        // Deal with the action and return a response.
        return "index";
    }



    /**
     * This is the init method action, it handles the
     * initialization part of the game
     * @return object
     */
    public function initAction() : object
    {
        // Init the game
        $diceGame = new DiceGame();

        $this->app->session->set("DiceGame", $diceGame);
        $this->app->session->set("activePlayer", "player");

        $this->app->session->set("roll", null);
        $this->app->session->set("sim", null);

        return $this->app->response->redirect("dice1/play");
    }



    /**
     * This is the get method action, it handles
     * the get part of the game.
     * @return object
     */
    public function playActionGet() : object
    {
        $title = "Tärning 100!";

        $histogram = new Histogram();
        $diceGame = $this->app->session->get("DiceGame");
        $histogram->injectData($diceGame);
        $value = $this->app->session->get("value");
        $roll = $this->app->session->get("roll");
        $sim = $this->app->session->get("sim");
        $activePlayer = $this->app->session->get("activePlayer");

        $playerTotal = $diceGame->player->getTotalScore();
        $playerCurrent = $diceGame->player->getCurrentScore();

        $computerTotal = $diceGame->computer->getTotalScore();

        // $rolls = $diceGame->getRolls();

        $data = [
            "diceGame" => $diceGame,
            "value" => $value,
            "playerCurrent" => $playerCurrent,
            "playerTotal" => $playerTotal,
            "computerTotal" => $computerTotal,
            "roll" => $roll,
            "activePlayer" => $activePlayer,
            "sim" => $sim,
            "histogram" => $histogram
        ];

        $this->app->page->add("dice1/play", $data);
        // $this->app->page->add("guess/debug");

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
        $activePlayer = $this->app->session->get("activePlayer");

        $diceGame = $this->app->session->get("DiceGame");
        $roll = $this->app->request->getPost("roll");
        $hold = $this->app->request->getPost("hold");
        $sim = $this->app->request->getPost("sim");
        $restart = $this->app->request->getPost("restart");

        $this->app->session->set("roll", $roll);
        $this->app->session->set("sim", $sim);


        if ($roll) {
            $diceGame->rollDice($activePlayer);
            $this->app->session->set("value", $diceGame->$activePlayer->dice->getNumber());

            if ($this->app->session->get("value") == 1 && $activePlayer == "player") {
                $this->app->session->set("activePlayer", "computer");
            } elseif ($this->app->session->get("value") == 1 && $activePlayer == "computer") {
                $this->app->session->set("activePlayer", "player");
            }
        }

        if ($hold) {
            $diceGame->$activePlayer->hold();

            $this->app->session->set("activePlayer", "computer");
        }

        if ($sim) {
            $diceGame->simComputer();
            $diceGame->$activePlayer->hold();

            $this->app->session->set("activePlayer", "player");
        }

        if ($restart) {
            $diceGame = new DiceGame();

            $this->app->session->set("DiceGame", $diceGame);
            $this->app->session->set("activePlayer", "player");

            // $activePlayer = $this->app->session->get("activePlayer");

            $this->app->session->set("roll", null);
            $this->app->session->set("sim", null);
        }

        return $this->app->response->redirect("dice1/play");
    }
}
