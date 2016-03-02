<?php

namespace Beequeue\Tweaky\Selector;

class ByValue implements SelectorInterface
{
    protected $value;

    public function __construct($value)
    {
        $this->value = $value;
    }

    public function matches($testVal)
    {
        return $this->value == $testVal;
    }
}
