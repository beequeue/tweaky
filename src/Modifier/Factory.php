<?php

namespace Beequeue\Tweaky\Modifier;

class Factory
{
    public static function create($val)
    {
        // @todo Other types of modifier

        // Last resort, just do a straight replace
        $modifier = new SimpleReplace($val);

        return $modifier;
    }
}
