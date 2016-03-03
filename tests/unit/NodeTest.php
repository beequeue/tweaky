<?php

namespace Beequeue\Test\Tweaky;

use Beequeue\Tweaky\Node;
use Beequeue\Tweaky\Selector\ByValue as ByValueSelector;
use Beequeue\Tweaky\Modifier\SimpleReplace as SimpleReplaceModifier;
use PHPUnit_Framework_TestCase as TestCase;

class NodeTest extends TestCase
{
    /** @var Node */
    protected $node;

    public function setUp()
    {
        $this->node = new Node(new ByValueSelector("some value"));
    }

    public function tearDown()
    {
        $this->node = null;
    }

    public function testConstructor()
    {
        $selector = new ByValueSelector("some other value");
        $this->node = new Node($selector);
        $this->assertSame($selector, $this->node->getSelector());
    }

    public function testSelector()
    {
        $selector = new ByValueSelector("another value");
        $this->node->setSelector($selector);
        $this->assertSame($selector, $this->node->getSelector());
    }

    public function testValueModifier()
    {
        $valueModifier = new SimpleReplaceModifier("new value");
        $this->node->setValueModifier($valueModifier);
        $this->assertSame($valueModifier, $this->node->getValueModifier());
    }

    public function testChildNodes()
    {
        $childNodes = [
            new Node(new ByValueSelector("a")),
            new Node(new ByValueSelector("b"))
        ];

        $this->node->setChildNodes($childNodes);
        $this->assertSame($childNodes, $this->node->getChildNodes());
    }
}
