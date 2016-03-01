<?php

namespace Beequeue\Test\Tweaky;

use Beequeue\Tweaky\Spec as TweakySpec;
use PHPUnit_Framework_TestCase as TestCase;

class SpecTest extends TestCase
{
    public function testParse()
    {
        $json = file_get_contents(dirname(__FILE__).'/../fixtures/spec_1.json');

        $tweaky = new TweakySpec($json);

        // @todo add assertions
    }
}
