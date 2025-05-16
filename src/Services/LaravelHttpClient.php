<?php

namespace Webhub\WeclappApiLaravel\Services;

use GuzzleHttp\Promise\PromiseInterface;
use GuzzleHttp\Psr7\Response;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
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

        $this->logRequestAndResponse($request, $laravelResponse);

        return new Response(
            $laravelResponse->status(),
            $laravelResponse->headers(),
            $laravelResponse->body()
        );
    }

    private function logRequestAndResponse(RequestInterface $request, PromiseInterface|\Illuminate\Http\Client\Response $laravelResponse): void
    {
        if (! config('weclapp.logging.enabled')) {
            return;
        }

        Log::channel('weclapp-api')->debug('Weclapp API Request', [
            'method' => $request->getMethod(),
            'url' => (string) $request->getUri(),
            'headers' => $request->getHeaders(),
            'body' => (string) $request->getBody(),
        ]);

        Log::channel('weclapp-api')->debug('Weclapp API Response', [
            'status' => $laravelResponse->status(),
            'headers' => $laravelResponse->headers(),
            'body' => $laravelResponse->body(),
        ]);
    }
}
