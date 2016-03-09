<?php

namespace Beequeue\Test\Tweaky\Modifier;

use Beequeue\Tweaky\Modifier\SimpleNumeric;
use PHPUnit_Framework_TestCase as TestCase;

class SimpleNumericTest extends TestCase
{
    public function executeProvider()
    {
        return [

            // Test addition
            ["+5", 3, 8],
            ["+5", 3.0, 8.0],
            ["+5.2", 3, 8.2],
            ["+-2", 3, 1],

            // Test subtraction
            ["-5", 10, 5],
            ["-5", 3.0, -2.0],
            ["-5.2", 10, 4.8],
            ["--2", 3, 5],

            // Test multiplication
            ["*5", 3, 15],
            ["*5", 3.0, 15.0],
            ["*5.2", 3, 15.6],
            ["*-2", 3, -6],

            // Test division
            ["/5", 15, 3],
            ["/5", 15.0, 3.0],
            ["/5.2", 15.6, 3.0],
            ["/-2", -6, 3],

            // Test with spaces
            ["+ 10", 10, 20],
            ["+    10", 10, 20]

        ];
    }

    /**
     * Test the execute method
     *
     * @param  mixed $expression  The value to construct modifier with
     * @param  mixed $input       The value to pass to matches method
     * @param  mixed $expected    Expected return value from execute method
     * @dataProvider executeProvider
     */
    public function testExecute($expression, $input, $expected)
    {
        $modifier = new SimpleNumeric($expression);
        $this->assertSame($expected, $modifier->execute($input));
    }

    public function isValidProvider()
    {
        return [

            // Valid
            ["+123", true], ["-123", true], ["*123", true], ["/123", true],
            ["+1.3", true], ["-1.3", true], ["*1.3", true], ["/1.3", true],
            ["+-13", true], ["--13", true], ["*-13", true], ["/-13", true],

            // Invalid operator
            ["?123", false],

            // Invalid number
            ["+NaN", false], ["+12.3.4", false]

        ];
    }

    /**
     * Test the isValid method
     *
     * @param  string $expression Parameter to isValid
     * @param  bool   $expected   Expected return value
     * @dataProvider isValidProvider
     */
    public function testIsValid($expression, $expected)
    {
        $this->assertSame($expected, SimpleNumeric::isValid($expression));
    }

    public function constructorExceptionProvider()
    {
        return [

            // Invalid expression
            ["invalid expression"],

            // Division by zero
            ["/0"], ["/0.0"], ["/-0"], ["/-0.0"]
        ];
    }

    /**
     * Test constructor throws exceptions
     *
     * @param  string $expression Paramter for constructor
     * @dataProvider constructorExceptionProvider
     * @expectedException Beequeue\Tweaky\Exception
     */
    public function testConstructorThrowsExceptions($expression)
    {
        $modifier = new SimpleNumeric($expression);
    }
}
