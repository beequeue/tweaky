<?php

namespace Beequeue\Tweaky;

use Beequeue\Tweaky\Selector\Factory as SelectorFactory;
use Beequeue\Tweaky\Modifier\Factory as ModifierFactory;

class Tweaky
{
    protected $spec;

    function __construct(SpecInterface $spec)
    {
        $this->spec = $spec;
    }

    public function process($input)
    {
        $processed = $input;

        foreach ($this->spec->getTransforms() as $nodes) {
            $this->applyNodes($nodes, $processed);
        }

        return $processed;
    }

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
