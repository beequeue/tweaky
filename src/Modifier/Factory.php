<?php

namespace Beequeue\Tweaky\Modifier;

use Beequeue\Tweaky\Options;

/**
 * Modifier factory
 */
class Factory
{
    /**
     * Generate an appropriate modifier based on the Tweaky value string
     *
     * @param  string $value The Tweaky value string
     * @param  Options $options Tweaky options
     * @return ModifierInterface The generated modifier object
     */
    public static function create($val, Options $options)
    {
        // @todo Other types of modifier

        // Last resort, just do a straight replace
        $modifier = new SimpleReplace($val);

        return $modifier;
    }
}
