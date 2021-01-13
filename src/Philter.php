<?php

declare(strict_types=1);

namespace Indgy;

use InvalidArgumentException;

/**
 * Philter is a fluent input sanitising class.
 * Use it by chaining methods together, finally calling toString() or toInt()
 * which will return the input having applied all the filters.
 *
 * @author Ian Grindley
 */
class Philter
{
    /**
     * @var Array - A list of filters to apply
     */
    private $filters;
    /**
     * @var Mixed - The initial value passed from the Request input
     */
    private $var;


    /**
     * Pass in the string to be filtered
     *
     * @param Scalar $var
     */
    public function __construct($var)
    {
        $this->filters = [];
        $this->setVar($var);
    }
    /**
     * Set the variable to be manipulated
     *
     * @param Mixed $var
     * @return Filter
     */
    private function setVar($var): Philter
    {
        if ( ! is_scalar($var)) {
            throw new InvalidArgumentException('Philter cannot filter a non scalar value, pass strings, integers, floats or booleans only');
        }
        $this->var = $var;
        return $this;
    }
    /**
     * Apply the filters and return the processed variable
     *
     * @return Mixed - The processed variable
     */
    private function process()
    {
        $var = $this->var;
        foreach ($this->filters as $callable) {
            $var = $callable($var);
        }

        return $var;
    }
    /**
     * Return the variable cast as a Boolean
     *
     * @return Boolean
     */
    public function toBool(): ?Bool
    {
        return (bool) $this->process();
    }
    /**
     * Return the variable cast as a Float
     *
     * @param Integer|null $decimals - Limit the number of decimal places
     * @return Float
     */
    public function toFloat(?Int $decimals=null): ?Float
    {
        $parts = array_map(function($v) {
            return preg_replace('/[^0-9]/', '', $v);
        }, explode('.', strrev((string) $this->process()), 2));
        // the var was reversed to capture the last decimal place,
        // now we un-reverse the separate units/decimal parts
        $parts = [
            strrev($parts[1]),
            strrev($parts[0]),
        ];
        if ( ! is_null($decimals)) {
            $parts[1] = substr($parts[1], 0, $decimals);
        }

        return (float) sprintf('%d.%d', $parts[0], $parts[1]);
    }
    /**
     * Return the variable cast as an Integer
     *
     * @return Integer
     */
    public function toInt(): ?Int
    {
        return (int) $this->process();
    }
    /**
     * Return the variable cast as a String
     *
     * @return string
     */
    public function toString(): ?String
    {
        return (string) $this->process();
    }
}

/**
 * @return Indgy\Philter
 */
function philter($var): Philter {
    return new Philter($var);
}
