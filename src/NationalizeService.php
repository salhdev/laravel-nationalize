<?php

declare(strict_types=1);

namespace Faicchia\Nationalize;

use Faicchia\Nationalize\Models\NationalizeResponse;
use Illuminate\Http\Client\Response;
use Illuminate\Support\Facades\Http;

class NationalizeService
{
    protected string $apiKey;
    protected string $url;
    protected array $names;

    public function __construct()
    {
        $this->apiKey = config('nationalize.apiKey');
        $this->url = config('nationalize.url');
    }

    public function name(array|string $name): static
    {
        if (is_array($name)) {
            $this->names = $name;
        } else {
            $this->names = [ $name ];
        }

        return $this;
    }

    public function names(array $names): static
    {
        $this->names = $names;

        return $this;
    }

    public function get(): NationalizeResponse
    {
        $queryParams = array_filter([
            'name' => $this->names,
            'apikey' => $this->apiKey,
        ]);

        $response = Http::get($this->url, $queryParams);

        return $this->responseBuilder($response);
    }

    private function responseBuilder(Response $response): NationalizeResponse
    {
        if ($response->clientError()) {
            return new NationalizeResponse(
                status: $response->status(),
                limit: (int) $response->header('X-Rate-Limit-Limit'),
                reset: (int) $response->header('X-Rate-Reset'),
                remaining: (int) $response->header('X-Rate-Limit-Remaining'),
                error: $response->object()->error
            );
        }

        return new NationalizeResponse(
            status: $response->status(),
            limit: (int) $response->header('X-Rate-Limit-Limit'),
            reset: (int) $response->header('X-Rate-Reset'),
            remaining: (int) $response->header('X-Rate-Limit-Remaining'),
            data: $response->object()
        );
    }
}