<?php

include_once "integration/ExchangeRateApiIntegration.php";

/* This was develop by a guy who knows basically nothing about exchange. 
Please, desconsider the part that don't make sense about exchange operations
and focus on the coding part haha */

class RecomendationUseCase implements IUseCase {

    private $integration = null;

    private $requestedExchanges = array();

    public function __construct() {
        $this->integration = new ExchangeRateApiIntegration;
        $this->requestedExchanges = explode(",", $_ENV['CURRENCIES']);
    }

    public function process() {
       $date = new DateTime();
       $exchangeHistory = array();
       for($i = 0; $i < 7; $i++) {
            $counter++;
            $date->sub(new DateInterval('P1D'));
            $response = $this->integration->historicRates($date->format("Y-m-d"));
            if($response !== false) {
                $exchangeHistory[] = $response->rates;
            } 
       }

       $averages = $this->getAverageRate($this->requestedExchanges, $exchangeHistory);
       $todayRatesResponse = $this->integration->latestRates();
       $recomendations = array();
       if(false !== $todayRatesResponse) {
            $todayRates = $todayRatesResponse->rates;
            foreach($averages as $currency => $value) {
                $recomendations[$currency] = "KEEP";

                if($value > $todayRates->{$currency}) {
                    $recomendations[$currency] = "BUY";
                } 

                if($value < $todayRates->{$currency}) {
                    $recomendations[$currency] = "SELL";
                } 
            }
       } 

       return $recomendations;
    }

    private function getAverageRate($currenciesToAverage, $data) {
        $acc = array_fill_keys($currenciesToAverage, 0);
        foreach($data as $rateArray) {
            foreach($currenciesToAverage as $currency) {
                $acc[$currency] += $rateArray->{$currency};
            }
        }

        return array_map(function($value) {
            return $value / 7;
        }, $acc);
    }
}