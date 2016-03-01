<?php

namespace Beequeue\Test\Tweaky;

use Beequeue\Tweaky\Tweaky;
use Beequeue\Tweaky\Spec as TweakySpec;
use PHPUnit_Framework_TestCase as TestCase;

class TweakyTest extends TestCase
{
    public function scenarioProvider()
    {
        $scenarioGlob = sprintf(
            '%s/fixtures/scenarios/*.json',
            dirname(__FILE__).'/..'
        );

        $files = [];
        foreach (glob($scenarioGlob) as $file) {
            $files[] = [$file];
        }

        return $files;
    }

    /**
     * Main scenario test handler
     *
     * @param  string $scenarioFile File containing spec, input and expected JSON
     * @dataProvider scenarioProvider
     */
    public function testProcess($scenarioFile)
    {
        $scenario = json_decode(file_get_contents($scenarioFile));

        $spec = new TweakySpec($scenario->tweaky);
        $tweaky = new Tweaky($spec);

        $output = $tweaky->process($scenario->input);

        $this->assertEquals($scenario->expected, $output);
    }
}
