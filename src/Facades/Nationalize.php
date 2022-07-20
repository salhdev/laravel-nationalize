<?php

declare(strict_types=1);

namespace Faicchia\Nationalize\Facades;

use Faicchia\Nationalize\NationalizeService;
use Illuminate\Support\Facades\Facade;

class Nationalize extends Facade
{
    protected static function getFacadeAccessor()
    {
        return NationalizeService::class;
    }
}
