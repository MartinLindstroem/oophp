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


    /**
     * Constructor to initiate the object,
     *
     */

    public function __construct(int $number = -1)
    {
        $this->number = $number;
    }


    /**
     * Randomize the number of the dice between the values 1 and 6.
     *
     * @return void
     */

    public function roll()
    {
        $this->number = rand(1, 6);
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
}
