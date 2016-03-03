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
}
