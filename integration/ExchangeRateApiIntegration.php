<?php

class ExchangeRateApiIntegration {

    private $client;

    public function __construct() {
        $this->client = new GuzzleHttp\Client(['base_uri' => 'https://api.exchangeratesapi.io']);
    }
    
    public function latestRates() {
        $res = $this->client->get('/latest');
        if($res->getStatusCode() == 200) {
            return json_decode($res->getBody()->getContents());
        }

        return false;
    }

    public function historicRates($date) {
        $res = $this->client->get("/$date");
        if($res->getStatusCode() == 200) {
            return json_decode($res->getBody()->getContents());
        }

        return false;
    }
}