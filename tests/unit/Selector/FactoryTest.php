<?php

namespace Beequeue\Test\Tweaky\Selector;

use Beequeue\Tweaky\Selector\Factory as SelectorFactory;
use Beequeue\Tweaky\Options;
use PHPUnit_Framework_TestCase as TestCase;

class FactoryTest extends TestCase
{
    public function createProvider()
    {
        return [

            // Check the various modifiers get created
            ["{[0]}", "Beequeue\Tweaky\Selector\ByArrayIndex"],
            ["somekey", "Beequeue\Tweaky\Selector\ByValue"],

            // Check an unknown tagged modifier falls through to simple replace
            ["{this-means-nothing}", "Beequeue\Tweaky\Selector\ByValue"]
        ];
    }

    /**
     * Test the create method
     *
     * @param string $val       The value to construct selector with
     * @param string $expected  Expected type of created selector
     * @dataProvider createProvider
     */
    public function testCreate($val, $expected)
    {
        // Given known options ...
        $options = new Options([
            'openingTag' => '{',
            'closingTag' => '}'
        ]);

        // ... when we create a selector from a given value ...
        $selector = SelectorFactory::create($val, $options);

        // ... it should be of the expected type
        $this->assertSame($expected, get_class($selector));
    }
}
