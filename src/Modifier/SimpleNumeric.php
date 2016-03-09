<?php

namespace Beequeue\Tweaky\Modifier;

use Beequeue\Tweaky\Exception;

/**
 * Do a simple mathematical operation
 *
 * The class is constructed with a string expression as follows:
 *
 * <dl>
 *  <dt>+<i>n</i></dt>
 *  <dd>Add <i>n</i> to the original value
 *  <dt>-<i>n</i></dt>
 *  <dd>Subtract <i>n</i> from the original value
 *  <dt>*<i>n</i></dt>
 *  <dd>Multiply the original value by <i>n</i>
 *  <dt>/<i>n</i></dt>
 *  <dd>Divide the original value by <i>n</i>
 * </dl>
 */
class SimpleNumeric implements ModifierInterface
{
    const OP_ADD = 1;
    const OP_SUBTRACT = 2;
    const OP_MULTIPLY = 3;
    const OP_DIVIDE = 4;

    /** @var int The operator to use.  See OP_* class constants */
    protected $op;

    /** @var mixed The value to use with the operator */
    protected $value;

    /**
     * The regex used to match suitable expressions
     *
     * Basically an operator followed by optional whitespace, followed by a number
     *
     * @var string
     */
    const REGEX = '/^([*+-\/])\s*([+-]?(?:(?:\d+(?:\.\d*)?)|(?:\.\d+)))$/';

    /**
     * Constructor
     *
     * @param string $expression The expression to parse, e.g. '+12'
     */
    public function __construct($expression)
    {
        if (!self::isValid($expression)) {
            throw new Exception('Expression invalid in constructor');
        }

        preg_match(self::REGEX, $expression, $matches);

        $this->value = $matches[2];

        switch ($matches[1]) {
            case '+':
                $this->op = self::OP_ADD;
                break;
            case '-':
                $this->op = self::OP_SUBTRACT;
                break;
            case '*':
                $this->op = self::OP_MULTIPLY;
                break;
            case '/':
                // Check for division-by-zero
                if ($this->value == 0) {
                    throw new Exception('Division by zero');
                }
                $this->op = self::OP_DIVIDE;
                break;
        }
    }

    /**
     * Execute the modifier on the input
     *
     * @param  mixed $input The value from the input object
     * @return mixed
     */
    public function execute($input)
    {
        switch ($this->op) {
            case self::OP_ADD:
                $result = $input + $this->value;
                break;
            case self::OP_SUBTRACT:
                $result = $input - $this->value;
                break;
            case self::OP_MULTIPLY:
                $result = $input * $this->value;
                break;
            case self::OP_DIVIDE:
                $result = $input / $this->value;
                break;
        }

        return $result;
    }

    /**
     * Determine if the passed expression is valid for the modifier
     *
     * @param  string $expression The expression to test
     * @return bool True if the expression is valid, otherwise false
     */
    public static function isValid($expression)
    {
        return (bool)preg_match(self::REGEX, $expression);
    }
}
