<?php

namespace Beequeue\Tweaky\Selector;

class AbstractSelector implements SelectorInterface
{
    public function matches($testVal)
    {
        return false;
    }
}
