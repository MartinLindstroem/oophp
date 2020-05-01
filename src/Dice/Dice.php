<?php

namespace Marty\Dice;

/**
 * Dice class for dice 100 game
 * represents the dice
 */


class Dice
{
    /**
     * @var int $number   The current rolled number number.
     *
     */
    private $number;
    private $sides;
    // private $rolls;


    /**
     * Constructor to initiate the object,
     *
     */

    public function __construct(int $number = -1, int $sides = 6)
    {
        $this->number = $number;
        $this->sides = $sides;
        // $this->rolls = [];
    }


    /**
     * Randomize the number of the dice between the values 1 and 6.
     *
     * @return void
     */

    public function roll()
    {
        $this->number = rand(1, 6);
        // $this->rolls[] = $this->number;
        // array_push($this->rolls, $this->number);
    }


    /**
    * Gets the latest rolled number
    *
    */
    public function getNumber()
    {
        return $this->number;
    }


    /**
    * Sets the number of the dice.
    * Mainly for testing.
    */
    public function setNumber($num)
    {
        $this->number = $num;
    }


    /**
     * Returns the number of sides on the die.
     * @return int
     */
    public function getSides()
    {
        return $this->sides;
    }


    // public function getRolls()
    // {
    //     return $this->rolls;
    // }
}
