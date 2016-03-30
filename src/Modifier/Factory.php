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
     * @param  string $val The Tweaky value string
     * @param  Options $options Tweaky options
     * @return ModifierInterface The generated modifier object
     */
    public static function create($val, Options $options)
    {
        $oTag = preg_quote($options->openingTag);
        $cTag = preg_quote($options->closingTag);

        // Does this look like an expression of some sort?
        if (preg_match('/^'.$oTag.'(.*)'.$cTag.'$/', $val, $matches)) {
            $expression = $matches[1];

            $modifiers = [
                'Beequeue\Tweaky\Modifier\SimpleNumeric'
            ];

            foreach ($modifiers as $m) {
                $result = call_user_func([$m, 'isValid'], $expression);
                if ($result === false) {
                    continue;
                }

                $modifier = new $m($expression);
                return $modifier;
            }
        }

        // Last resort, just do a straight replace
        $modifier = new SimpleReplace($val);
        return $modifier;
    }
}
