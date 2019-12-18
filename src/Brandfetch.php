<?php

namespace CoreAlg;

use CoreAlg\Curl;
use Exception;

class Brandfetch{

    private $api = "https://api.brandfetch.io/v1";
    private $key;
    private $curl;
    private $headers;

    /**
     * Create a new Brandfetch instance.
     *
     * @param string $key Your brandfetch API Key
     * @return void
     */
    public function __construct($key = null)
    {
        $this->key = $key;

        if(is_null($key)){
            throw new Exception("Api key missing");
        }

        $this->curl = new Curl();
        $this->setAuthorizationHeader();
    }

    /**
     * This function returns a company's logo & icon
     * @param string $domain Your desiard domain (www.example.com)
     * @return array
     */
    public function getLogo(string $domain) :array
    {
        $endpoint = "{$this->api}/logo";

        $payload = [
            "domain" => $domain,
            "fresh" => false,
            "renderJS" => false
        ];

        $response = $this->curl->post($endpoint, $payload, $this->headers);

        return $this->processResponse($response);
    }

    /**
     * This function returns a company's colors
     * @param string $domain Your desiard domain (www.example.com)
     * @return array
     */
    public function getColor(string $domain): array
    {
        $endpoint = "{$this->api}/color";

        $payload = [
            "domain" => $domain
        ];

        $response = $this->curl->post($endpoint, $payload, $this->headers);

        return $this->processResponse($response);
    }

    /**
     * This function returns a company's fonts
     * @param string $domain Your desiard domain (www.example.com)
     * @return array
     */
    public function getFont(string $domain): array
    {
        $endpoint = "{$this->api}/font";

        $payload = [
            "domain" => $domain
        ];

        $response = $this->curl->post($endpoint, $payload, $this->headers);

        return $this->processResponse($response);
    }

    /**
     * This function returns a company's images
     * @param string $domain Your desiard domain (www.example.com)
     * @return array
     */
    public function getImage(string $domain): array
    {
        $endpoint = "{$this->api}/image";

        $payload = [
            "domain" => $domain
        ];

        $response = $this->curl->post($endpoint, $payload, $this->headers);

        return $this->processResponse($response);
    }

    /**
     * This function returns a company's data
     * @param string $domain Your desiard domain (www.example.com)
     * @return array
     */
    public function getCompanyInfo(string $domain): array
    {
        $endpoint = "{$this->api}/company";

        $payload = [
            "domain" => $domain
        ];

        $response = $this->curl->post($endpoint, $payload, $this->headers);

        return $this->processResponse($response);
    }

    private function setAuthorizationHeader() :void
    {
        $this->headers = [
            CURLOPT_HTTPHEADER => [
                "x-api-key: {$this->key}",
                "Content-Type: application/json"
            ]
        ];
    }

    private function processResponse($response)
    {
        if ($response["status"] === "error") {
            $message = $response["data"]["response"] ?? "Unknown error.";

            return [
                "status" => "error",
                "code" => $response["code"],
                "message" => $message,
                "data" => []
            ];
        }

        return [
            "status" => "success",
            "code" => $response["code"],
            "message" => "",
            "data" => $response["data"]["response"] ?? null
        ];
    }
}