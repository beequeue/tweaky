<?php

namespace Beequeue\Test\Tweaky;

use Beequeue\Tweaky\JsonUtils;
use PHPUnit_Framework_TestCase as TestCase;

class JsonUtilsTest extends TestCase
{
    public function testCleanDecodeStripsComments()
    {
        $json = '// Comment at start' . PHP_EOL .
                '{"key1": "val1", /* Block comment */' . PHP_EOL .
                ' "key2": "val2"  // Line comment' . PHP_EOL .
                '} /* Comment at end */';

        $decoded = JsonUtils::clean_decode($json, true);

        $expected = [
            'key1' => 'val1',
            'key2' => 'val2'
        ];

        $this->assertSame($decoded, $expected);
    }
}
