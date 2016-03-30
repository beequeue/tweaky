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

    /**
     * @expectedException Beequeue\Tweaky\Exception
     */
    public function testConstructorThrowsOnInvalidJson()
    {
        $val = "I'm not JSON!";
        $spec = new TweakySpec($val);
    }

    /**
     * @expectedException Beequeue\Tweaky\Exception
     */
    public function testConstructorThrowsOnInvalidOptions()
    {
        $val = '{"valid_json":true}';
        $invalidOptions = "I'm not an Beequeue\Tweaky\Options object!";
        $spec = new TweakySpec($val, $invalidOptions);
    }
}
