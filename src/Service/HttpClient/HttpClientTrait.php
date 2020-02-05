<?php

namespace App\Service\HttpClient;

/**
 * Trait HttpClientTrait
 * @package App\Service\HttpClient
 */
trait HttpClientTrait
{
    protected $httpClientOptions;

    protected function getHttpClient($reset = false): HttpClient
    {
        static $httpClient;

        if (!$httpClient || $reset) {
            $httpClient = new HttpClient(
                $this->parameterBag->get(
                    'http_client'
                )
            );
        }

        return $httpClient;
    }
}
