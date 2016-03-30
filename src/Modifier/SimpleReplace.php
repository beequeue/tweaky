<?php

namespace Beequeue\Tweaky\Modifier;

/**
 * Do a simple replace using the supplied value
 */
class SimpleReplace implements ModifierInterface
{
    /** @var mixed The value to set */
    protected $value;

    /**
     * Constructor
     *
     * @param mixed $value The value to set
     */
    public function __construct($value)
    {
        $this->value = $value;
    }

    /**
     * Execute the modifier on the input
     *
     * @param  mixed $input The value from the input object
     * @return mixed
     */
    public function execute($input)
    {
        return $this->value;
    }

    /**
     * Determine if the passed expression is valid for the modifier
     *
     * @param  mixed $expression The expression to test
     * @return bool Always returns true
     */
    public static function isValid($expression)
    {
        return true;
    }
}
