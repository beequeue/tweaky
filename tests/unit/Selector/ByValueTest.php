<?php

namespace Beequeue\Test\Tweaky\Selector;

use Beequeue\Tweaky\Selector\ByValue;
use PHPUnit_Framework_TestCase as TestCase;

class ByValueTest extends TestCase
{
    public function matchesProvider()
    {
        return [
            ["myKey", "myKey", true],
            ["myKey", "notMyKey", false]
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
        $selector = new ByValue($selectorVal);
        $this->assertSame($isMatch, $selector->matches($testVal));
    }
}
