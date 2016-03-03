<?php

namespace Beequeue\Tweaky;

use Beequeue\Tweaky\Selector\SelectorInterface;
use Beequeue\Tweaky\Modifier\ModifierInterface;

/**
 * Represents a transform node in a Tweaky spec
 *
 * This object wraps a selector and modifier fragment in the Tweaky spec, e.g.
 * <code>{..., 'key': 'val', ... }</code> or <code>{..., 'key': {'subkey': 'val'},
 *  ... }</code>.  Consequently it only makes sense to set either the childNodes
 * or the valueModifier property but not both.
 */
class Node
{
    /** @var SelectorInterface The selector this node uses to identify targets */
    protected $selector;

    /** @var ModifierInterface The (optional) modifier used by the node */
    protected $valueModifier;

    /** @var Node[] Optional child nodes */
    protected $childNodes = [];

    /**
     * Constructor
     *
     * @param SelectorInterface $selector The selector this node uses to identify targets
     */
    public function __construct(SelectorInterface $selector)
    {
        $this->setSelector($selector);
    }

    /**
     * Setter for selector
     *
     * @param SelectorInterface $selector The selector this node uses to identify targets
     */
    public function setSelector(SelectorInterface $selector)
    {
        $this->selector = $selector;
    }

    /**
     * Getter for selector
     *
     * @return SelectorInterface The selector this node uses to identify targets
     */
    public function getSelector()
    {
        return $this->selector;
    }

    /**
     * Setter for valueModifier
     *
     * @param ModifierInterface $valueModifier The modifier used by the node
     */
    public function setValueModifier(ModifierInterface $valueModifier)
    {
        $this->valueModifier = $valueModifier;
    }

    /**
     * Getter for valueModifier
     *
     * @return ModifierInterface The modifier used by the node
     */
    public function getValueModifier()
    {
        return $this->valueModifier;
    }

    /**
     * Setter for childNodes
     *
     * @param Node[] $nodes Child Node objects
     */
    public function setChildNodes(array $nodes)
    {
        $this->childNodes = $nodes;
    }

    /**
     * Getter for childNodes
     *
     * @return Node[] Child Node objects
     */
    public function getChildNodes()
    {
        return $this->childNodes;
    }
}
