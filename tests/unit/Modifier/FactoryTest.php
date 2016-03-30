<?php

namespace Beequeue\Test\Tweaky\Modifier;

use Beequeue\Tweaky\Modifier\Factory as ModifierFactory;
use Beequeue\Tweaky\Options;
use PHPUnit_Framework_TestCase as TestCase;

class FactoryTest extends TestCase
{
    public function createProvider()
    {
        return [

            // Check the various modifiers get created
            ["{+5}", "Beequeue\Tweaky\Modifier\SimpleNumeric"],
            ["someval", "Beequeue\Tweaky\Modifier\SimpleReplace"],

            // Check an unknown tagged modifier falls through to simple replace
            ["{this-means-nothing}", "Beequeue\Tweaky\Modifier\SimpleReplace"]
        ];
    }

    /**
     * Test the create method
     *
     * @param string $val       The value to construct modifier with
     * @param string $expected  Expected type of created modifier
     * @dataProvider createProvider
     */
    public function testCreate($val, $expected)
    {
        // Given known options ...
        $options = new Options([
            'openingTag' => '{',
            'closingTag' => '}'
        ]);

        // ... when we create a modifier from a given value ...
        $modifier = ModifierFactory::create($val, $options);

        // ... it should be of the expected type
        $this->assertSame($expected, get_class($modifier));
    }
}
