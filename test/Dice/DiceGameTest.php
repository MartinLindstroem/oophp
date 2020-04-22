<?php

namespace Marty\Dice;

use PHPUnit\Framework\TestCase;

/**
 * Test cases for class DiceGame.
 */

class DiceGameTest extends TestCase
{
    /**
     * Construct object and verify that the object has the expected
     * properties. Use no arguments.
     */
    public function testCreateObject()
    {
        $diceGame = new DiceGame();
        $this->assertInstanceOf("\Marty\Dice\DiceGame", $diceGame);

        $res = $diceGame->player;
        $this->assertIsObject($res);

        $res = $diceGame->computer;
        $this->assertIsObject($res);

        $res = count($diceGame->computerRolls);
        $exp = 0;
        $this->assertEquals($exp, $res);
    }



    /**
     * Construct object and verify that the object gets the expected
     * value.
     */
    public function testPlayerRollDice()
    {
        $diceGame = new DiceGame();
        $diceGame->rollDice("player");

        $res = $diceGame->player->dice->getNumber();
        $this->assertGreaterThanOrEqual(1, $res);
    }



    /**
     * Construct object and verify that the object gets the expected
     * value.
     */
    public function testComputerRollDice()
    {
        $diceGame = new DiceGame();
        $diceGame->rollDice("computer");

        $res = $diceGame->computer->dice->getNumber();
        $this->assertGreaterThanOrEqual(1, $res);
    }



    /**
     * Construct object and verify that the value is appended
     * to the computerRolls array.
     */
    public function testComputerRollArray()
    {
        $diceGame = new DiceGame();
        $diceGame->simComputer();

        $res = count($diceGame->computerRolls);
        $this->assertGreaterThanOrEqual(1, $res);
    }
}
