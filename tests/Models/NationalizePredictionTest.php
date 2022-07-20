<?php

declare(strict_types=1);

use Faicchia\Nationalize\Models\NationalizePrediction;

it('sets data correctly', function () {
    $data = (object) [
        'name' => 'Michael',
        'country' => [
            (object) [
                'country_id' => 'US',
                'probability' => 0.08986482266532715,
            ],
            (object) [
                'country_id' => 'AU',
                'probability' => 0.05976757527083082,
            ],
            (object) [
                'country_id' => 'NZ',
                'probability' => 0.04666974820852911,
            ],
        ],
    ];

    expect( new NationalizePrediction($data) )
        ->name->toBe('Michael')
        ->countries->toHaveCount(3)->toBe([
            'US' => 0.08986482266532715,
            'AU' => 0.05976757527083082,
            'NZ' => 0.04666974820852911,
        ]);
});

it('sets data correctly skipping predictions without country_id', function () {
    $data = (object) [
        'name' => 'Michael',
        'country' => [
            (object) [
                'country_id' => 'US',
                'probability' => 0.08986482266532715,
            ],
            (object) [
                'country_id' => 'AU',
                'probability' => 0.05976757527083082,
            ],
            (object) [
                'country_id' => '',
                'probability' => 0.04666974820852911,
            ],
        ],
    ];

    expect( new NationalizePrediction($data) )
        ->name->toBe('Michael')
        ->countries->toHaveCount(2)->toBe([
            'US' => 0.08986482266532715,
            'AU' => 0.05976757527083082,
        ]);
});
