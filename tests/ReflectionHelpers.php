<?php

namespace Hamidrezaniazi\Pecs\Tests;

use ReflectionClass;
use ReflectionObject;

trait ReflectionHelpers
{
    protected static function privateCall(object $object, $name, array $args = []): mixed
    {
        $class = new ReflectionClass($object);
        $method = $class->getMethod($name);

        return $method->invokeArgs($object, $args);
    }

    protected static function getPrivateProperty(object $object, string $name): mixed
    {
        $class = new ReflectionObject($object);
        $property = $class->getProperty($name);

        return $property->getValue($object);
    }

    protected function setPrivateProperty(object $object, string $property, mixed $value): void
    {
        $reflection = new ReflectionClass($object);
        $reflectionProperty = $reflection->getProperty($property);
        $reflectionProperty->setValue($object, $value);
    }
}
