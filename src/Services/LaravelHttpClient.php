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
            ->withBody(
                (string) $request->getBody(),
                $request->getHeaderLine('Content-Type') ?: 'application/json',
            )
            ->baseUrl(config('weclapp.api_base_url'))
            ->send($request->getMethod(), (string) $request->getUri());

        $this->logRequestAndResponse($request, $laravelResponse);

        // Extract validation errors if they exist in the decoded response
        $body = $laravelResponse->body();
        if ($laravelResponse->failed() && $laravelResponse->json()) {
            $decoded = $laravelResponse->json();
            if (isset($decoded['validationErrors']) || isset($decoded['errors'])) {
                // Include validation errors in the response body
                $body = json_encode($decoded);
            }
        }

        return new Response(
            $laravelResponse->status(),
            $laravelResponse->headers(),
            $body
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
