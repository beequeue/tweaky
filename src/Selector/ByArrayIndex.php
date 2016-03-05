<?php

namespace Beequeue\Tweaky\Selector;

/**
 * A selector that matches by array index, i.e. integer
 *
 * The class is constructed with a square-bracket enclosed string, which contains
 * one or more comma-separated specifiers as follows:
 *
 * <dl>
 *  <dt>[<i>n</i>]</dt>
 *  <dd>Matches the array index <i>n</i>
 *  <dt>[<i>min</i>-<i>max</i>]</dt>
 *  <dd>Matches indexes between <i>min</i> and <i>max</i> inclusive</dd>
 *  <dt>[*]</dt>
 *  <dd>Matches all indexes</dd>
 * </dl>
 *
 * A circumflex (^) can precede a specifier to negate it, e.g. <code>[0-9,^5]</code>
 * would match all indices up to 9, except 5.  Negated checks take priority
 * regardless of the position of their specifier.
 */
class ByArrayIndex implements SelectorInterface
{
    /**
     * Array of checks inputs are tested against
     *
     * Each item in this array can either be an int (indicating a simple value
     * check), an array of two ints (indicating a range check), or the string
     * '*' (indicating all indexes)
     *
     * @var array
     */
    protected $positiveChecks = [];

    /**
     * Array of negative checks inputs are tested against
     *
     * See {@link positiveChecks} for details
     *
     * @var array
     */
    protected $negativeChecks = [];

    /**
     * Constructor
     *
     * @param mixed $indexValue The encoded index value
     */
    public function __construct($indexValue)
    {
        // Check for the [ and ] from either side of the specifiers
        if (!preg_match('/^\[(.*)\]$/', $indexValue, $matches)) {
            return;
        }

        $specifiers = explode(',', $matches[1]);

        foreach ($specifiers as $specifier) {
            if (mb_substr($specifier, 0, 1) == '^') {
                $this->negativeChecks[] = $this->parseSpecifier(mb_substr($specifier, 1));
            } else {
                $this->positiveChecks[] = $this->parseSpecifier($specifier);
            }
        }
    }

    /**
     * Parse an individual specifier string into a check item
     *
     * @param  string $specifier
     * @return mixed
     */
    protected function parseSpecifier($specifier)
    {
        if ($specifier == '*') {
            return '*';
        }

        if (preg_match('/^\d+$/', $specifier)) {
            return intval($specifier);
        }

        if (preg_match('/^(\d+)-(\d+)$/', $specifier, $matches)) {
            return [intval($matches[1]), intval($matches[2])];
        }
    }

    /**
     * Determine whehter the testValue matches the given specifier
     *
     * @param  mixed $specifier
     * @param  mixed $testVal
     * @return bool
     */
    protected function matchesSpecifier($specifier, $testVal)
    {
        // [*] - wildcard
        if ($specifier == '*') {
            return true;
        }

        // [n] - equality
        if (is_int($specifier) && $specifier === $testVal) {
            return true;
        }

        // [min-max] - range check
        if (is_array($specifier) && count($specifier) == 2
            && is_int($specifier[0]) && $testVal >= $specifier[0]
            && is_int($specifier[1]) && $testVal <= $specifier[1]
        ) {
            return true;
        }

        return false;
    }

    /**
     * Returns true if the passed value satisfies the currently parsed checks
     *
     * @param  mixed $testVal The value to check
     * @return bool
     */
    public function matches($testVal)
    {
        // Array indices must be integers
        if (!is_int($testVal)) {
            return false;
        }

        if ($this->negativeChecks) {
            foreach ($this->negativeChecks as $negSpecifier) {
                if ($this->matchesSpecifier($negSpecifier, $testVal)) {
                    return false;
                }
            }
        }

        if ($this->positiveChecks) {
            foreach ($this->positiveChecks as $posSpecifier) {
                if ($this->matchesSpecifier($posSpecifier, $testVal)) {
                    return true;
                }
            }
        }

        return false;
    }
}
