<?php

namespace Beequeue\Test\Tweaky\Modifier;

use Beequeue\Tweaky\Modifier\SimpleReplace;
use PHPUnit_Framework_TestCase as TestCase;

class SimpleReplaceTest extends TestCase
{
    public function testExecute()
    {
        // Should just do a straight replace with the new value
        $newValue = "new value";
        $modifier = new SimpleReplace($newValue);
        $result = $modifier->execute("old value");
        $this->assertSame($newValue, $result);
    }

    public function testIsValid()
    {
        // Should always return true
        $this->assertTrue(SimpleReplace::isValid('val'));
        $this->assertTrue(SimpleReplace::isValid(0));
        $this->assertTrue(SimpleReplace::isValid(null));
    }
}
