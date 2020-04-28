<?php

namespace Marty\Dice;

use Anax\Commons\AppInjectableInterface;
use Anax\Commons\AppInjectableTrait;

// use Anax\Route\Exception\ForbiddenException;
// use Anax\Route\Exception\NotFoundException;
// use Anax\Route\Exception\InternalErrorException;

/**
 * A sample controller to show how a controller class can be implemented.
 * The controller will be injected with $app if implementing the interface
 * AppInjectableInterface, like this sample class does.
 * The controller is mounted on a particular route and can then handle all
 * requests for that mount point.
 *
 * @SuppressWarnings(PHPMD.TooManyPublicMethods)
 */
class DiceController implements AppInjectableInterface
{
    use AppInjectableTrait;



    /**
     * @var string $db a sample member variable that gets initialised
     */
    // private $db = "not active";



    /**
     * The initialize method is optional and will always be called before the
     * target method/action. This is a convienient method where you could
     * setup internal properties that are commonly used by several methods.
     *
     * @return void
     */
    // public function initialize() : void
    // {
    //     // Use to initialise member variables.
    //     $this->db = "active";
    //
    //     // Use $this->app to access the framework services.
    // }



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
     * This is the index method action, it handles:
     * ANY METHOD mountpoint
     * ANY METHOD mountpoint/
     * ANY METHOD mountpoint/index
     *
     * @return string
     */
    public function initAction() : object
    {
        // Init the game
        $diceGame = new DiceGame();
        // $_SESSION["DiceGame"] = $diceGame;
        // $_SESSION["activePlayer"] = "player";
        $this->app->session->set("DiceGame", $diceGame);
        $this->app->session->set("activePlayer", "player");

        // $activePlayer = $this->app->session->get("activePlayer");

        // $_SESSION["roll"] = null;
        // $_SESSION["sim"] = null;
        $this->app->session->set("roll", null);
        $this->app->session->set("sim", null);

        return $this->app->response->redirect("dice1/play");
    }



    /**
     * This is the index method action, it handles:
     * ANY METHOD mountpoint
     * ANY METHOD mountpoint/
     * ANY METHOD mountpoint/index
     *
     * @return string
     */
    public function playActionGet() : object
    {
        $title = "Tärning 100!";

        // $diceGame = $_SESSION["DiceGame"];
        // $value = $_SESSION["value"] ?? null;
        // $roll = $_SESSION["roll"] ?? null;
        // $sim = $_SESSION["sim"] ?? null;
        // $activePlayer = $_SESSION["activePlayer"] ?? null;
        $diceGame = $this->app->session->get("DiceGame");
        $value = $this->app->session->get("value");
        $roll = $this->app->session->get("roll");
        $sim = $this->app->session->get("sim");
        $activePlayer = $this->app->session->get("activePlayer");

        $playerTotal = $diceGame->player->getTotalScore();
        $playerCurrent = $diceGame->player->getCurrentScore();

        $computerTotal = $diceGame->computer->getTotalScore();



        $data = [
            "diceGame" => $diceGame,
            "value" => $value,
            "playerCurrent" => $playerCurrent,
            "playerTotal" => $playerTotal,
            "computerTotal" => $computerTotal,
            "roll" => $roll,
            "activePlayer" => $activePlayer,
            "sim" => $sim
        ];

        $this->app->page->add("dice1/play", $data);
        // $this->app->page->add("guess/debug");

        return $this->app->page->render([
            "title" => $title,
        ]);
    }



    /**
     * This is the index method action, it handles:
     * ANY METHOD mountpoint
     * ANY METHOD mountpoint/
     * ANY METHOD mountpoint/index
     *
     * @return string
     */
    public function playActionPost() : object
    {
        // $activePlayer = $_SESSION["activePlayer"] ?? null;
        // $_SESSION["roll"] = $_POST["roll"] ?? null;
        // $_SESSION["sim"] = $_POST["sim"] ?? null;
        //
        // $diceGame = $_SESSION["DiceGame"];
        // $roll = $_POST["roll"] ?? null;
        // $hold = $_POST["hold"] ?? null;
        // $sim = $_POST["sim"] ?? null;
        // $restart = $_POST["restart"] ?? null;

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
            // $_SESSION["value"] = $diceGame->$activePlayer->dice->getNumber();
            $this->app->session->set("value", $diceGame->$activePlayer->dice->getNumber());

            // if ($_SESSION["value"] == 1 && $activePlayer == "player") {
            //     $_SESSION["activePlayer"] = "computer";
            // } elseif ($_SESSION["value"] == 1 && $activePlayer == "computer") {
            //     $_SESSION["activePlayer"] = "player";
            // }
            if ($this->app->session->get("value") == 1 && $activePlayer == "player") {
                $this->app->session->set("activePlayer", "computer");
            } elseif ($this->app->session->get("value") == 1 && $activePlayer == "computer") {
                $this->app->session->set("activePlayer", "player");
            }
        }

        if ($hold) {
            $diceGame->$activePlayer->hold();
            // $_SESSION["activePlayer"] = "computer";
            $this->app->session->set("activePlayer", "computer");
        }

        if ($sim) {
            $diceGame->simComputer();
            $diceGame->$activePlayer->hold();
            // $_SESSION["activePlayer"] = "player";
            $this->app->session->set("activePlayer", "player");
        }

        if ($restart) {
            $diceGame = new DiceGame();
            // $_SESSION["DiceGame"] = $diceGame;
            // $_SESSION["activePlayer"] = "player";
            $this->app->session->set("DiceGame", $diceGame);
            $this->app->session->set("activePlayer", "player");

            // $activePlayer = $_SESSION["activePlayer"] ?? null;
            $activePlayer = $this->app->session->get("activePlayer");

            // $_SESSION["roll"] = null;
            // $_SESSION["sim"] = null;
            $this->app->session->set("roll", null);
            $this->app->session->set("sim", null);
        }

        return $this->app->response->redirect("dice1/play");
    }

}
