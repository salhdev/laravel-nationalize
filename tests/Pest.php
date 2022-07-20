<?php

declare(strict_types=1);

use Faicchia\Nationalize\Tests\TestCase;

uses(TestCase::class)->in(__DIR__);

function getPrivatePropertyValue(object $obj, string $propertyName)
{
    $reflector = new \ReflectionObject($obj);
    $property = $reflector->getProperty($propertyName);
    $property ->setAccessible(true);

    return $property->getValue($obj);
}
