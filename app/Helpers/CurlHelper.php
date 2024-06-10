<?php

namespace App\Helpers;

use GuzzleHttp\Promise\PromiseInterface;
use Illuminate\Http\Client\ConnectionException;
use Illuminate\Http\Client\Response;
use Illuminate\Support\Facades\Http;


trait CurlHelper
{
    /**
     * @throws ConnectionException
     */
    public function get(
        string $url,
        array $headers = []
    ): PromiseInterface|Response {
        return Http::withHeaders($headers)->get($url);
    }

    /**
     * @throws ConnectionException
     */
    public function post(string $url, array $headers = [], array $data = []): PromiseInterface|Response
    {
        return Http::withHeaders($headers)->post($url, $data);
    }

}