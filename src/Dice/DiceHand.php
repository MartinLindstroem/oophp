<?php

namespace Marty\Dice;

/**
 * Dice class for dice 100 game
 * represents the dice hand
 */

class DiceHand
{
    /**
     * @var int $currentScore   The players score current round.
     * @var int $totalScore     The players total score.
     */
    private $currentScore;
    private $totalScore;

    /**
     * Constructor to initiate the object,
     *
     */

    public function __construct(int $currentScore = 0, int $totalScore = 0)
    {
        $this->currentScore = $currentScore;
        $this->totalScore = $totalScore;
        $this->dice = new Dice();
    }


    /**
    * Rolls the dice and updates current score
    * @return void
    */

    public function rollDice()
    {
        $this->dice->roll();
        if ($this->dice->getNumber() != 1) {
            $this->currentScore += $this->dice->getNumber();
        } else {
            $this->currentScore = 0;
            $this->hold();
        }
    }



    /**
    * Returns the current score
    *
    */
    public function getCurrentScore()
    {
        return $this->currentScore;
    }



    /**
    * Returns the total score
    *
    */
    public function getTotalScore()
    {
        return $this->totalScore;
    }



    /**
    * Sets the current score
    * Mainly for testing
    */
    public function setCurrentScore($num)
    {
        $this->currentScore = $num;
    }



    /**
    * Sets the total score
    * Mainly for testing
    */
    public function setTotalScore($num)
    {
        $this->totalScore = $num;
    }


    /**
    * Function for when player wants to "hold".
    * Increases the total score by current round score
    * and sets the current round score to 0
    */
    public function hold()
    {
        $this->totalScore += $this->currentScore;
        $this->currentScore = 0;
    }
}
