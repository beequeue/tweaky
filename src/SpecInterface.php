<?php

namespace Beequeue\Tweaky;

/**
 * Interace for Spec objects
 */
interface SpecInterface
{
    /**
     * Return the array of transform Node arrays
     * @return Node[][]
     */
    public function getTransforms();
}
