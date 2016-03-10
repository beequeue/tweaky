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
        if (!is_object($input)) {
            $input = JsonUtils::cleanDecode($input);
            if (!$input) {
                throw new Exception(
                    '$input is not valid JSON'
                );
            }
        }
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
        // We're only interested in arrays and objects
        if (!is_object($input) && !is_array($input)) {
            return;
        }

        // Iterate the current branch of transform nodes
        foreach ($nodes as $node) {

            // Iterate the current input branch.  Due to the nature of
            // json_decode, $key will either be a string if the branch was an
            // object in JSON form, or an int if it was an array in JSON form.
            // The selector will use this distinction when deciding if it's an
            // array-matching hit or not

            foreach ($input as $key => &$val) {

                // Should this input be handled by the current transform node?
                if (!$node->getSelector()->matches($key)) {
                    continue;
                }

                // Does this node modify the inputs value or indicate further
                // traversal to the next branch?
                if ($valueModifier = $node->getValueModifier()) {
                    $val = $valueModifier->execute($val);
                } elseif ($childNodes = $node->getChildNodes()) {
                    $this->applyNodes($childNodes, $val);
                }

            }
        }
    }
}
