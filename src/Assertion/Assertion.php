<?php


namespace Assertion;

use Assert\Assertion as BeberleiAssertion;

class Assertion extends BeberleiAssertion
{
    protected static function createException($value, $message, $code, $propertyPath = null, array $constraints = array())
    {
        return new \InvalidArgumentException($message, $code);
    }
}
