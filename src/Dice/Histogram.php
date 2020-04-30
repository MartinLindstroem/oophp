<?php

namespace Marty\Dice;

/**
 * A class implementing histogram for integers.
 */
class Histogram
{
    /**
     * @var array $serie  The numbers stored in sequence.
     * @var int   $min    The lowest possible number.
     * @var int   $max    The highest possible number.
     */
    private $serie = [];
    private $min;
    private $max;



    /**
     * Get the serie.
     *
     * @return array with the serie.
     */
    public function getHistogramSerie()
    {
        return $this->serie;
    }



    /**
     * Print out the histogram, default is to print out only the numbers
     * in the serie, but when $min and $max is set then print also empty
     * values in the serie, within the range $min, $max.
     *
     * @param int $min The lowest possible integer number.
     * @param int $max The highest possible integer number.
     *
     * @return string representing the histogram.
     */
    public function printHistogram()
    {
        $avg = 0;
        if ($this->serie) {
            $avg = round(array_sum($this->serie) / count($this->serie), 2);
        }
        $counts = array_count_values($this->serie);
        $myStr = "";
        for ($i=1; $i < 7; $i++) {
            if (in_array($i, $this->serie)) {
                $myStr .= $i . ": " . str_repeat("*", $counts[$i]) . "\n";
            } else {
                $myStr .= $i . ": " . "\n";
            }
        }
        $myStr .= "Snittvärde: " . $avg . "\n";
        return $myStr;
    }




    /**
     * Inject the object to use as base for the histogram data.
     *
     * @param HistogramInterface $object The object holding the serie.
     *
     * @return void.
     */
    public function injectData(HistogramInterface $object)
    {
        $this->serie = $object->getHistogramSerie();
        $this->min   = $object->getHistogramMin();
        $this->max   = $object->getHistogramMax();
    }
}
