<?php

namespace Beequeue\Tweaky;

use Beequeue\Tweaky\Selector\Factory as SelectorFactory;
use Beequeue\Tweaky\Modifier\Factory as ModifierFactory;

class Spec implements SpecInterface
{
    /** @var string */
    protected $name;

    /** @var array Array of Node[] */
    protected $transforms = [];

    function __construct($spec)
    {
        if (is_string($spec)) {
            $spec = JsonUtils::clean_decode($spec);
        }

        $this->parse($spec);
    }

    protected function parse($spec)
    {
        if (!empty($spec->transforms)) {
            foreach ($spec->transforms as $t) {
                $this->transforms[] = $this->parseTransform($t);
            }
        }
    }

    protected function parseTransform($t)
    {
        $nodes = [];

        // Determine if we're dealing with an array or an object
        if (is_object($t)) {

            // Iterate the object props ...
            foreach ($t as $key => $val) {

                // ... determining their selector type
                $tSelector = SelectorFactory::create($key);
                $node = new Node($tSelector);

                // ... and values
                if (is_object($val)) {

                    // If it's an object, we need to recurse down another level
                    $node->setChildNodes($this->parseTransform($val));

                } else {

                    // If not an object, we should apply a value modifier
                    $valModifier = ModifierFactory::create($val);
                    $node->setValueModifier($valModifier);

                }

                $nodes[] = $node;
            }
        }

        return $nodes;
    }

    public function getTransforms()
    {
        return $this->transforms;
    }
}
