<?php

namespace Beequeue\Tweaky\Selector;

/**
 * Selector factory
 */
class Factory
{
    /**
     * Generate an appropriate selector based on the Tweaky selector string
     *
     * @param  string $key The Tweaky selector string
     * @return SelectorInterface The generated selector object
     */
    public static function create($key)
    {
        if (preg_match('/^\{(\[.*\])\}$/', $key, $matches)) {
            $selector = new ByArrayIndex($matches[1]);
        } else {
            // Last resort, just do a straight value check
            $selector = new ByValue($key);
        }

        return $selector;
    }
}
