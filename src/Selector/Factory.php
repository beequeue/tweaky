<?php

namespace Beequeue\Tweaky\Selector;

class Factory
{
    public static function create($key)
    {
        // @todo Other types of selector

        // Last resort, just do a straight value check
        $selector = new ByValue($key);

        return $selector;
    }
}
