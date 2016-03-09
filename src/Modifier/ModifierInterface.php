<?php

namespace Beequeue\Tweaky\Modifier;

/**
 * Interface for modifiers
 */
interface ModifierInterface
{
    /**
     * Execute the modifier on the input
     *
     * @param  mixed $input The value from the input object
     * @return mixed
     */
    public function execute($input);

    /**
     * Determine if the passed expression is valid for the modifier
     *
     * @param  string $expression The expression to test
     * @return bool True if the expression can be handled by the modifeer, otherwise false
     */
    public static function isValid($expression);
}
