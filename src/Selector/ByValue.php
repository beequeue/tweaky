<?php

namespace Beequeue\Tweaky\Selector;

/**
 * A selector that matches by value equality
 */
class ByValue implements SelectorInterface
{
    /** @var mixed The value to check inputs against */
    protected $value;

    /**
     * Constructor
     *
     * @param mixed $value The value to check inputs against
     */
    public function __construct($value)
    {
        $this->value = $value;
    }

    /**
     * Returns true if the passed value is equal in value to the current selector
     *
     * @param  mixed $testVal The value to check
     * @return bool
     */
    public function matches($testVal)
    {
        return $this->value == $testVal;
    }
}
