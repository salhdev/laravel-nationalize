<?php

declare(strict_types=1);

namespace Faicchia\Nationalize\Models;

class NationalizeResponse
{
    private null|array|NationalizePrediction $result = null;

    public function __construct(
        private int $status,
        private int $limit,
        private int $reset,
        private int $remaining,
        private null|string $error = null,
        null|array $data = null,
    ) {
        $this->setResult($data);
    }

    private function setResult(null|array $data): void
    {
        if ($data === null || count($data) === 0) {
            return;
        }

        if (count($data) === 1) {
            $this->result = new NationalizePrediction($data[0]);

            return;
        }

        $this->result = collect($data)
            ->map(fn ($item) => new NationalizePrediction($item))
            ->toArray();
    }

    public function __get(string $name)
    {
        if (property_exists($this, $name)) {
            return $this->$name;
        }
    }
}
