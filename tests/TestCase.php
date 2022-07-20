<?php

declare(strict_types=1);

namespace Faicchia\Nationalize\Tests;

use Faicchia\Nationalize\NationalizeServiceProvider;

class TestCase extends \Orchestra\Testbench\TestCase
{
    protected function getPackageProviders($app)
    {
        return [
            NationalizeServiceProvider::class
        ];
    }
}