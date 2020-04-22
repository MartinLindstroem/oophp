<?php

namespace Marty\Dice;

use PHPUnit\Framework\TestCase;

/**
 * Test cases for class Dice.
 */

class DiceTest extends TestCase
{
    /**
     * Construct object and verify that the object has the expected
     * properties. Use no arguments.
     */
    public function testCreateObject()
    {
        $dice = new Dice();
        $this->assertInstanceOf("\Marty\Dice\Dice", $dice);

        $res = $dice->getNumber();
        $exp = -1;
        $this->assertEquals($exp, $res);
    }



    /**
     * Construct object and verify that function
     * sets the right value.
     */
    public function testRollDiceGreaterThan()
    {
        $dice = new Dice();
        $dice->roll();
        $res = $dice->getNumber();
        $this->assertGreaterThanOrEqual(1, $res);
    }



    /**
     * Construct object and verify that function
     * sets the right value.
     */
    public function testRollDiceLessThan()
    {
        $dice = new Dice();
        $dice->roll();
        $res = $dice->getNumber();
        $this->assertLessThanOrEqual(6, $res);
    }



    /**
     * Verify that the number of the dice
     * can be set.
     */
    public function testSetDiceNumber()
    {
        $dice = new Dice();
        $dice->setNumber(4);
        $res = $dice->getNumber();
        $exp = 4;
        $this->assertEquals($exp, $res);
    }
}
