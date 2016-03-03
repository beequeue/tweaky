<?php

namespace Beequeue\Tweaky;

use Beequeue\Tweaky\Selector\Factory as SelectorFactory;
use Beequeue\Tweaky\Modifier\Factory as ModifierFactory;

/**
 * Main processing class
 */
class Tweaky
{
    /** @var SepcInterface The spec object to use when processing data */
    protected $spec;

    /**
     * Constructor
     *
     * @param SpecInterface $spec The spec object to use when processing data
     */
    public function __construct(SpecInterface $spec)
    {
        $this->spec = $spec;
    }

    /**
     * Process the passed data using the current spec
     *
     * @param  object $input The object to process
     * @return object The processed object
     */
    public function process($input)
    {
        $processed = $input;

        foreach ($this->spec->getTransforms() as $nodes) {
            $this->applyNodes($nodes, $processed);
        }

        return $processed;
    }

    /**
     * Recursively process the input using the supplied transform nodes
     *
     * @param  Node[] $nodes  An array of Node objects
     * @param  mixed &$input  The input to process
     * @return null
     */
    protected function applyNodes(array $nodes, &$input)
    {
        if (is_object($input)) {

            foreach ($nodes as $node) {
                foreach ($input as $key => &$val) {

                    if (!$node->getSelector()->matches($key)) {
                        continue;
                    }

                    if ($valueModifier = $node->getValueModifier()) {
                        $val = $valueModifier->execute($val);
                    } elseif ($childNodes = $node->getChildNodes()) {
                        $this->applyNodes($childNodes, $val);
                    }
                }
            }
        }
    }
}
