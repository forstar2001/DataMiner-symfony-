<?php

namespace App\Service\HttpClient;

use GuzzleHttp;

class HttpClient
{
    protected const HTTP_HEADERS = [
        'Accept' => 'application/json, text/plain, */*',
        'Accept-Encoding' => 'gzip, deflate, br',
        'Accept-Language' => 'en-US,en;q=0.9,ru;q=0.8',
        'Cache-Control' => 'no-cache',
        'Connection' => 'keep-alive',
        'Content-Type' => 'application/json;charset=UTF-8',
        'Pragma' => 'no-cache',
        'User-Agent' => 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/73.0.3683.103 Safari/537.36',
    ];

    protected $options;

    protected $httpClient;

    protected $proxy;

    protected $query;

    public function __construct(array $options)
    {
        $this->httpClient = new GuzzleHttp\Client(
            [
                'cookies' => true,
                'timeout' => $options['connection_timeout'],
                'debug' => $options['debug_mode'],
            ]
        );
        $this->proxy = $options['proxy_uri'];
    }

    public function getQuery(): array
    {
        return $this->query;
    }

    public function request(array $query, bool $decode = true)
    {
        $options = current(
            $query
        );

        if (!array_key_exists('proxy', $options)) {
            $options['proxy'] = $this->proxy;
        }

        $this->query = $query;
        $response = $this->httpClient->send(
            (
                new GuzzleHttp\Psr7\Request(
                    array_shift(
                        $options
                    ),
                    null,
                    self::HTTP_HEADERS
                )
            )->withUri(
                new GuzzleHttp\Psr7\Uri(
                    key(
                        $query
                    )
                )
            ),
            $options
        )->getBody()->getContents();

        if ($decode) {
            return GuzzleHttp\json_decode(
                $response,
                true
            );
        }

        return $response;
    }
}
