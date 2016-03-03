<?php

namespace Beequeue\Tweaky\Selector;

/**
 * Interface for selector objects
 */
interface SelectorInterface
{
    /**
     * Returns true if the passed value matches the current selector
     *
     * @param  mixed $testVal The value to check
     * @return bool
     */
    public function matches($testVal);
}
