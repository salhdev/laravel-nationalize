<?php

declare(strict_types=1);

use Faicchia\Nationalize\Facades\Nationalize;
use Faicchia\Nationalize\NationalizeService;

test('facade is called correctly', function () {
    expect(Nationalize::name('Michael'))
        ->toBeInstanceOf(NationalizeService::class);
});
