<?php

declare(strict_types=1);

use Faicchia\Nationalize\Models\NationalizePrediction;
use Faicchia\Nationalize\Models\NationalizeResponse;

it('sets data correctly when having a single prediction', function () {
    $response = new NationalizeResponse(
        status: 200,
        limit: 1000,
        reset: 20000,
        remaining: 999,
        data: json_decode(file_get_contents('tests/stubs/response_200_single-name.json')),
    );

    expect($response)
        ->status->toBe(200)
        ->limit->toBe(1000)
        ->reset->toBe(20000)
        ->remaining->toBe(999)
        ->error->toBeNull()
        ->result->toBeInstanceOf(NationalizePrediction::class);
});

it('sets data correctly when having multiple predictions', function () {
    $response = new NationalizeResponse(
        status: 200,
        limit: 1000,
        reset: 20000,
        remaining: 999,
        data: json_decode(file_get_contents('tests/stubs/response_200_multiple-names.json')),
    );

    expect($response)
        ->status->toBe(200)
        ->limit->toBe(1000)
        ->reset->toBe(20000)
        ->remaining->toBe(999)
        ->error->toBeNull()
        ->result->toBeArray();
});

it('sets data correctly when there is an error', function () {
    $response = new NationalizeResponse(
        status: 401,
        limit: 0,
        reset: 0,
        remaining: 0,
        error: "Invalid API key",
    );

    expect($response)
        ->status->toBe(401)
        ->limit->toBe(0)
        ->reset->toBe(0)
        ->remaining->toBe(0)
        ->error->toBe('Invalid API key')
        ->result->toBeNull();
});
