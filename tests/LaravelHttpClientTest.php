<?php

use GuzzleHttp\Psr7\Request;
use Illuminate\Support\Facades\Http;
use Webhub\WeclappApiLaravel\Services\LaravelHttpClient;

beforeEach(function () {
    config([
        'weclapp.api_base_url' => 'https://weclapp.example.com',
        'weclapp.auth_token' => 'test-token',
    ]);
});

it('forwards the request Content-Type header to the outgoing request', function () {
    Http::fake([
        'weclapp.example.com/*' => Http::response(['ok' => true]),
    ]);

    $request = new Request(
        'POST',
        '/document/upload?name=Windgutachten.pdf',
        ['Content-Type' => 'application/pdf'],
        '%PDF-1.4 fake pdf body',
    );

    (new LaravelHttpClient)->sendRequest($request);

    Http::assertSent(fn ($sent) => $sent->header('Content-Type')[0] === 'application/pdf');
});

it('falls back to application/json when no Content-Type is set on the request', function () {
    Http::fake([
        'weclapp.example.com/*' => Http::response(['ok' => true]),
    ]);

    $request = new Request('POST', '/some/endpoint', [], '{"key":"value"}');

    (new LaravelHttpClient)->sendRequest($request);

    Http::assertSent(fn ($sent) => $sent->header('Content-Type')[0] === 'application/json');
});
