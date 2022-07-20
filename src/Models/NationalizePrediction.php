<?php

declare(strict_types=1);

namespace Faicchia\Nationalize\Models;

class NationalizePrediction
{
    private string $name;
    private array $countries;

    public function __construct(object $data)
    {
        $this->name = $data->name;
        $this->setCountries($data->country);
    }

    public function setCountries(array $countries): void
    {
        $this->countries = collect($countries)
            ->mapWithKeys(function ($item, $key) {
                return [$item->country_id => $item->probability];
            })
            ->reject(function ($item, $key) {
                return $key === "";
            })
            ->all();
    }

    public function __get(string $name)
    {
        if (property_exists($this, $name)) {
            return $this->$name;
        }
    }
}
