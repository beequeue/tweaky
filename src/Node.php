<?php

namespace Beequeue\Tweaky;

use Beequeue\Tweaky\Selector\SelectorInterface;
use Beequeue\Tweaky\Modifier\ModifierInterface;

class Node
{
    protected $selector;

    protected $valueModifier;

    protected $childNodes = [];

    function __construct(SelectorInterface $selector)
    {
        $this->setSelector($selector);
    }

    public function setSelector(SelectorInterface $selector)
    {
        $this->selector = $selector;
    }

    public function getSelector()
    {
        return $this->selector;
    }

    public function setValueModifier(ModifierInterface $valueModifier)
    {
        $this->valueModifier = $valueModifier;
    }

    public function getValueModifier()
    {
        return $this->valueModifier;
    }

    public function setChildNodes(array $nodes)
    {
        $this->childNodes = $nodes;
    }

    public function getChildNodes()
    {
        return $this->childNodes;
    }
}
