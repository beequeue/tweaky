<?php

namespace Beequeue\Tweaky\Modifier;

class SimpleReplace implements ModifierInterface
{
    protected $value;

    public function __construct($value)
    {
        $this->value = $value;
    }

    public function execute($input)
    {
        return $this->value;
    }
}
