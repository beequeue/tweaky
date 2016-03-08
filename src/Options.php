<?php

namespace Beequeue\Tweaky;

use Zend\Stdlib\AbstractOptions;

/**
 * Options used when processing Tweaky specs
 */
class Options extends AbstractOptions
{
    /** @var string The string used to open Tweaky expressions */
    protected $openingTag = '{';

    /** @var string The string used to close Tweaky expressions */
    protected $closingTag = '}';

    /**
     * Gets the value of openingTag
     *
     * @return string
     */
    public function getOpeningTag()
    {
        return $this->openingTag;
    }

    /**
     * Sets the value of openingTag
     *
     * @param string $openingTag The opening tag
     * @return self
     */
    public function setOpeningTag($openingTag)
    {
        if (!is_string($openingTag)) {
            throw new Exception('Opening tag must be of type string');
        } elseif (!$openingTag) {
            throw new Exception('Opening tag cannot be empty');
        }
        $this->openingTag = $openingTag;

        return $this;
    }

    /**
     * Gets the value of closingTag
     *
     * @return string
     */
    public function getClosingTag()
    {
        return $this->closingTag;
    }

    /**
     * Sets the value of closingTag
     *
     * @param mixed $closingTag The closing tag
     * @return self
     */
    public function setClosingTag($closingTag)
    {
        if (!is_string($closingTag)) {
            throw new Exception('Closing tag must be of type string');
        } elseif (!$closingTag) {
            throw new Exception('Closing tag cannot be empty');
        }
        $this->closingTag = $closingTag;

        return $this;
    }
}
