<?php

namespace Marty\Dice;

use PHPUnit\Framework\TestCase;

/**
 * Test cases for class DiceGame.
 */


class HistogramTest extends TestCase
{
    public function testCreateObject()
    {
        $histogram = new Histogram();
        $this->assertInstanceOf("\Marty\Dice\Histogram", $histogram);

        $res = $histogram->getHistogramSerie();
        $exp = 0;
        $this->assertCount($exp, $res);
    }



    public function testInjectData()
    {
        $histogram = new Histogram();
        $diceGame = new DiceGame();

        $histogram->injectData($diceGame);

        $res = $diceGame->getHistogramMin();
        $exp = 1;
        $this->assertEquals($exp, $res);
    }




    public function testPrintHistogram()
    {
        $histogram = new Histogram();
        $diceGame = new DiceGame();
        $diceGame->rollDice("player");
        $histogram->injectData($diceGame);

        $res = $histogram->printHistogram();
        $exp = "*";
        $this->assertContains($exp, $res);
    }
}
