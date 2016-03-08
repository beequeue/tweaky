<?php

namespace Beequeue\Test\Tweaky;

use Beequeue\Tweaky\Options as TweakyOptions;
use PHPUnit_Framework_TestCase as TestCase;

class OptionsTest extends TestCase
{
    public function testOpeningTag()
    {
        $opts = new TweakyOptions();

        // Test using magic getter/setter
        $val = '{magic';
        $opts->openingTag = $val;
        $this->assertSame($val, $opts->openingTag);

        // Test using direct getter/setter
        $val = '{direct';
        $opts->setOpeningTag($val);
        $this->assertSame($val, $opts->getOpeningTag());
    }

    public function testClosingTag()
    {
        $opts = new TweakyOptions();

        // Test using magic getter/setter
        $val = 'magic}';
        $opts->closingTag = $val;
        $this->assertSame($val, $opts->closingTag);

        // Test using direct getter/setter
        $val = 'direct}';
        $opts->setClosingTag($val);
        $this->assertSame($val, $opts->getClosingTag());
    }

    public function incorrectTagsProvider()
    {
        $data = [];

        foreach (['openingTag', 'closingTag'] as $tagType) {

            // Empty tags are not allowed
            $data[] = [$tagType, ''];

            // Non-strings are not allowed
            $data[] = [$tagType, 123];
            $data[] = [$tagType, ['an', 'array']];

        }

        return $data;
    }

    /**
     * @dataProvider incorrectTagsProvider
     * @expectedException Beequeue\Tweaky\Exception
     */
    public function testIncorrectTagsThrowExceptions($tagType, $tagVal)
    {
        $opts = new TweakyOptions();
        $opts->{$tagType} = $tagVal;
    }

    public function testDefaults()
    {
        $opts = new TweakyOptions();
        $this->assertEquals('{', $opts->openingTag);
        $this->assertEquals('}', $opts->closingTag);
    }

    public function testConstructor()
    {
        $opts = new TweakyOptions([
            'openingTag' => '{{{',
            'closingTag' => '}}}'
        ]);

        $this->assertEquals('{{{', $opts->openingTag);
        $this->assertEquals('}}}', $opts->closingTag);
    }
}
