<?php

namespace Webhub\WeclappApiLaravel\Services;

use Illuminate\Support\Facades\Http;
use Psr\Http\Client\ClientInterface;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;

class LaravelHttpClient implements ClientInterface
{
    public function sendRequest(RequestInterface $request): ResponseInterface
    {
        $laravelResponse = Http::withHeaders([
            'AuthenticationToken' => config('weclapp.auth_token'),
            ...$request->getHeaders(),
        ])
            ->withBody((string) $request->getBody())
            ->baseUrl(config('weclapp.api_base_url'))
            ->send($request->getMethod(), (string) $request->getUri());

        // Transform Laravel's response into a PSR-7 Response
        return new \GuzzleHttp\Psr7\Response(
            $laravelResponse->status(),
            $laravelResponse->headers(),
            $laravelResponse->body()
        );
    }
}
