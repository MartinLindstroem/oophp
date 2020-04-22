<?php

namespace Marty\Dice;

use PHPUnit\Framework\TestCase;

/**
 * Test cases for class DiceHand.
 */

class DiceHandTest extends TestCase
{
    /**
     * Construct object and verify that the object has the expected
     * properties. Use no arguments.
     */
    public function testCreateObject()
    {
        $diceHand = new DiceHand();
        $this->assertInstanceOf("\Marty\Dice\DiceHand", $diceHand);

        $res = $diceHand->getCurrentScore();
        $exp = 0;
        $this->assertEquals($exp, $res);

        $res = $diceHand->getTotalScore();
        $exp = 0;
        $this->assertEquals($exp, $res);
    }



    /**
     * Construct object and verify that the current score
     * can be set.
     */
    public function testSetCurrentScore()
    {
        $diceHand = new DiceHand();

        $diceHand->setCurrentScore(10);
        $res = $diceHand->getCurrentScore();
        $exp = 10;
        $this->assertEquals($exp, $res);
    }



    /**
     * Construct object and verify that the total score
     * can be set
     */
    public function testSetTotalScore()
    {
        $diceHand = new DiceHand();

        $diceHand->setTotalScore(52);
        $res = $diceHand->getTotalScore();
        $exp = 52;
        $this->assertEquals($exp, $res);
    }



    /**
     * Construct object and verify that the total score
     * is increased by the current score and current score
     * gets set to 0 when hold.
     */
    public function testHold()
    {
        $diceHand = new DiceHand();

        $diceHand->setTotalScore(21);
        $diceHand->setCurrentScore(11);
        $diceHand->hold();

        $res = $diceHand->getTotalScore();
        $exp = 32;
        $this->assertEquals($exp, $res);

        $res = $diceHand->getCurrentScore();
        $exp = 0;
        $this->assertEquals($exp, $res);
    }
}
