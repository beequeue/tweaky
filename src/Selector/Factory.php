<?php

namespace Beequeue\Tweaky\Selector;

use Beequeue\Tweaky\Options;

/**
 * Selector factory
 */
class Factory
{
    /**
     * Generate an appropriate selector based on the Tweaky selector string
     *
     * @param  string $key The Tweaky selector string
     * @param  Options $options Tweaky options
     * @return SelectorInterface The generated selector object
     */
    public static function create($key, Options $options)
    {
        $oTag = preg_quote($options->openingTag);
        $cTag = preg_quote($options->closingTag);

        if (preg_match('/^'.$oTag.'(\[.*\])'.$cTag.'$/', $key, $matches)) {
            $selector = new ByArrayIndex($matches[1]);
        } else {
            // Last resort, just do a straight value check
            $selector = new ByValue($key);
        }

        return $selector;
    }
}
