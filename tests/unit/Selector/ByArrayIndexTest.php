<?php

namespace Beequeue\Test\Tweaky\Selector;

use Beequeue\Tweaky\Selector\ByArrayIndex;
use PHPUnit_Framework_TestCase as TestCase;

class ByArrayIndexTest extends TestCase
{
    public function matchesProvider()
    {
        return [

            // Match index 0
            ["[0]", 0, true],

            // Don't match if index is a string
            ["[0]", "0", false],

            // Match arbitrary index
            ["[25]", 25, true],

            // Don't match incorrect index
            ["[25]", 24, false],

            // Match multiple simple specifiers
            ["[1,3]", 1, true], ["[1,3]", 2, false], ["[1,3]", 3, true],

            // Match range
            ["[4-6]", 3, false], ["[4-6]", 4, true], ["[4-6]", 5, true],
            ["[4-6]", 6, true], ["[4-6]", 7, false],

            // Wildcard
            ["[*]", 4, true], ["[*]", 55, true], ["[*]", 0, true],
            ["[*]", "10", false],

            // Negation
            ["[^4]", 4, false], ["[^4]", 55, false],

            // Negation takes priority regardless of order
            ["[4,^4]", 4, false], ["[^4,4]", 4, false],

            // Negation of simple vs. range
            ["[0-10,^4]", 4, false],

            // Negation of range vs. simple
            ["[^0-10,4]", 4, false],

            // Negation of range vs. range
            ["[0-10,^4-6]", 3, true], ["[0-10,^4-6]", 5, false],
            ["[0-10,^4-6]", 7, true]
        ];
    }

    /**
     * Test the matches method
     *
     * @param  mixed $selectorVal The value to construct selector with
     * @param  mixed $testVal     The value to pass to matches method
     * @param  bool  $isMatch     Expected return value from matches method
     * @dataProvider matchesProvider
     */
    public function testMatches($selectorVal, $testVal, $isMatch)
    {
        $selector = new ByArrayIndex($selectorVal);
        $this->assertSame($isMatch, $selector->matches($testVal));
    }

    /**
     * @expectedException Beequeue\Tweaky\Exception
     */
    public function testConstructorThrowsOnInvalidIndexValue()
    {
        $selectorVal = "I don't start with [ and end with ].";
        $selector = new ByArrayIndex($selectorVal);
    }

    /**
     * @expectedException Beequeue\Tweaky\Exception
     */
    public function testParseSpecifierThrowsOnInvalidSpecifier()
    {
        $selectorVal = "[not-valid]";
        $selector = new ByArrayIndex($selectorVal);
    }
}
