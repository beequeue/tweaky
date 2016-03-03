<?php

namespace Beequeue\Tweaky\Modifier;

/**
 * Modifier factory
 */
class Factory
{
    /**
     * Generate an appropriate modifier based on the Tweaky value string
     *
     * @param  string $value The Tweaky value string
     * @return ModifierInterface The generated modifier object
     */
    public static function create($val)
    {
        // @todo Other types of modifier

        // Last resort, just do a straight replace
        $modifier = new SimpleReplace($val);

        return $modifier;
    }
}
