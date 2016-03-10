<?php

namespace Beequeue\Tweaky;

use Beequeue\Tweaky\Selector\Factory as SelectorFactory;
use Beequeue\Tweaky\Modifier\Factory as ModifierFactory;

/**
 * A parsed Tweaky spec
 */
class Spec implements SpecInterface
{
    /** @var string */
    protected $name;

    /** @var array Array of Node[] */
    protected $transforms = [];

    /** @var Options Tweaky options */
    protected $options;

    /**
     * Constructor
     *
     * @param string|object $spec The JSON spec to parse
     * @param Options|null  $options Tweaky options.  If not set, defaults will be used
     */
    public function __construct($spec, $options = null)
    {
        if (is_null($options)) {
            $options = new Options();
        } elseif (!is_a($options, 'Beequeue\Tweaky\Options')) {
            throw new Exception(
                '$options passed to Spec must be of type Beequeue\Tweaky\Options'
            );
        }
        $this->options = $options;

        if (is_string($spec)) {
            $spec = JsonUtils::cleanDecode($spec);
            if (!$spec) {
                throw new Exception(
                    '$spec passed to Spec is not valid JSON'
                );
            }
        }

        $this->parse($spec);
    }

    /**
     * Parse the passed spec
     *
     * @param  object $spec
     * @return null
     */
    protected function parse($spec)
    {
        if (!empty($spec->transforms)) {
            foreach ($spec->transforms as $t) {
                $this->transforms[] = $this->parseTransform($t);
            }
        }
    }

    /**
     * Parse the passed transform JSON objects into transform nodes
     *
     * @param  object $t A transform object from within the spec JSON
     * @return Node[]
     */
    protected function parseTransform($t)
    {
        $nodes = [];

        // Determine if we're dealing with an array or an object
        if (is_object($t)) {

            // Iterate the object props ...
            foreach ($t as $key => $val) {

                // ... determining their selector type
                $tSelector = SelectorFactory::create($key, $this->options);
                $node = new Node($tSelector);

                // ... and values
                if (is_object($val)) {

                    // If it's an object, we need to recurse down another level
                    $node->setChildNodes($this->parseTransform($val));

                } else {

                    // If not an object, we should apply a value modifier
                    $valModifier = ModifierFactory::create($val, $this->options);
                    $node->setValueModifier($valModifier);

                }

                $nodes[] = $node;
            }
        }

        return $nodes;
    }

    /**
     * Return the array of transform Node arrays
     *
     * @return Node[][]
     */
    public function getTransforms()
    {
        return $this->transforms;
    }
}
