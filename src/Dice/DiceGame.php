<?php

namespace Marty\Dice;

/**
 * DiceGame class for dice 100 game
 * handles the game logic
 */

class DiceGame implements HistogramInterface
{

    use HistogramTrait;
     /**
      * Constructor to initiate the object,
      *
      */

    public function __construct()
    {
        $this->player = new DiceHand();
        $this->computer = new DiceHand();
        $this->computerRolls = [];
        $this->nrOfRolls = 0;
    }



     /**
      * Function to roll the dice. Used for rolling the dice
      * for either the player or the computer
      * @return void
      */
    public function rollDice($player)
    {
        if ($player == "player") {
            $this->player->rollDice();
            array_push($this->serie, $this->player->dice->getNumber());
        } else {
            $this->computer->rollDice();
            array_push($this->serie, $this->computer->dice->getNumber());
        }
    }



    /**
     * Function to simulate the computers play turn. Computer rolls the dice
     * a number of times depending on the scores.
     * appends the dice values to the computerRolls array.
     */
    public function simComputer()
    {
        $this->computerRolls = [];

        if ($this->player->getTotalScore() >= $this->computer->getTotalScore() + 30) {
            $this->nrOfRolls = rand(5, 7);
        } elseif ($this->player->getTotalScore() >= $this->computer->getTotalScore() + 20) {
            $this->nrOfRolls = rand(4, 5);
        } else {
            $this->nrOfRolls = rand(2, 4);
        }

        for ($i=0; $i < $this->nrOfRolls; $i++) {
            $this->rollDice("computer");
            if ($this->computer->dice->getNumber() == 1) {
                array_push($this->computerRolls, $this->computer->dice->getNumber());
                return;
            }
            array_push($this->computerRolls, $this->computer->dice->getNumber());
        }
    }


    /**
     * Returns the number of rolls the computer is
     * supposed to make.
     * @return int
     */
    public function getNrOfRolls()
    {
        return $this->nrOfRolls;
    }
}
