<?php

declare(strict_types=1);

use Faicchia\Nationalize\Models\NationalizePrediction;
use Faicchia\Nationalize\Models\NationalizeResponse;
use Faicchia\Nationalize\NationalizeService;
use Illuminate\Support\Facades\Http;

beforeEach(
    fn () => $this->service = new NationalizeService()
);

test('service is correct type', function () {
    expect($this->service)
        ->toBeInstanceOf(NationalizeService::class);
});

test('name() function works correctly with string', function () {
    $this->service->name('Michael');
    $names = getPrivatePropertyValue($this->service, 'names');

    expect($names)
        ->toBeArray()
        ->toHaveCount(1)
        ->toContain('Michael');
});

test('name() function works correctly with array of string', function () {
    $this->service->name(['Michael', 'John']);
    $names = getPrivatePropertyValue($this->service, 'names');

    expect($names)
        ->toBeArray()
        ->toHaveCount(2)
        ->toContain('Michael')
        ->toContain('John');
});

test('names() function works correctly with array of string', function () {
    $this->service->names(['Michael', 'John']);
    $names = getPrivatePropertyValue($this->service, 'names');

    expect($names)
        ->toBeArray()
        ->toHaveCount(2)
        ->toContain('Michael')
        ->toContain('John');
});

test('200 response is handled correctly when passing a single name', function () {
    $url = config('nationalize.url') . "?" . http_build_query([
            'name' => [
                'Michael',
            ],
        ]);

    Http::fake([
        $url => Http::response(
            body: file_get_contents('tests/stubs/response_200_single-name.json'),
            headers: [
                'X-Rate-Limit-Limit' => '1000',
                'X-Rate-Reset' => '20000',
                'X-Rate-Limit-Remaining' => '999',
            ]
        ),
    ]);

    expect( $this->service->name('Michael')->get() )
        ->toBeInstanceOf(NationalizeResponse::class)
        ->status->toBe(200)
        ->limit->toBe(1000)
        ->reset->toBe(20000)
        ->remaining->toBe(999)
        ->error->toBeNull()
        ->result->toBeInstanceOf(NationalizePrediction::class);

    Http::assertSent(
        fn ($request): bool => $request->url() === $url
    );
});

test('200 response is handled correctly when passing multiple names using name() function', function () {
    $url = config('nationalize.url') . "?" . http_build_query([
            'name' => [
                'Michael',
                'Kevin',
            ],
        ]);

    Http::fake([
        $url => Http::response(
            body: file_get_contents('tests/stubs/response_200_multiple-names.json'),
            headers: [
                'X-Rate-Limit-Limit' => '1000',
                'X-Rate-Reset' => '20000',
                'X-Rate-Limit-Remaining' => '999',
            ]
        ),
    ]);

    expect( $this->service->name(['Michael', 'Kevin'])->get() )
        ->toBeInstanceOf(NationalizeResponse::class)
        ->status->toBe(200)
        ->limit->toBe(1000)
        ->reset->toBe(20000)
        ->remaining->toBe(999)
        ->error->toBeNull()
        ->result->toBeArray();

    Http::assertSent(
        fn ($request): bool => $request->url() === $url
    );
});

test('200 response is handled correctly when passing multiple names using names() function', function () {
    $url = config('nationalize.url') . "?" . http_build_query([
            'name' => [
                'Michael',
                'Kevin',
            ],
        ]);

    Http::fake([
        $url => Http::response(
            body: file_get_contents('tests/stubs/response_200_multiple-names.json'),
            headers: [
                'X-Rate-Limit-Limit' => '1000',
                'X-Rate-Reset' => '20000',
                'X-Rate-Limit-Remaining' => '999',
            ]
        ),
    ]);

    expect( $this->service->names(['Michael', 'Kevin'])->get() )
        ->toBeInstanceOf(NationalizeResponse::class)
        ->status->toBe(200)
        ->limit->toBe(1000)
        ->reset->toBe(20000)
        ->remaining->toBe(999)
        ->error->toBeNull()
        ->result->toBeArray();

    Http::assertSent(
        fn ($request): bool => $request->url() === $url
    );
});
