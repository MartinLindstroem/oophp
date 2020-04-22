<?php

namespace Marty\Dice;

/**
 * DiceGame class for dice 100 game
 * handles the game logic
 */

class DiceGame
{
     /**
      * Constructor to initiate the object,
      *
      */

    public function __construct()
    {
        $this->player = new DiceHand();
        $this->computer = new DiceHand();
        $this->computerRolls = [];
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
        } else {
            $this->computer->rollDice();
        }
    }



    /**
     * Function to simulate the computers play turn. Computer rolls the dice
     * between 2 and 4 times.
     * appends the dice values to the computerRolls array.
     */
    public function simComputer()
    {
        $this->computerRolls = [];
        $nrOfRolls = rand(2, 4);
        // $start = 0;
        for ($i=0; $i < $nrOfRolls; $i++) {
            $this->rollDice("computer");
            if ($this->computer->dice->getNumber() == 1) {
                array_push($this->computerRolls, $this->computer->dice->getNumber());
                return;
            }
            array_push($this->computerRolls, $this->computer->dice->getNumber());
        }
    }
}
