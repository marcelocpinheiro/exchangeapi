<?php

include_once "integration/ExchangeRateApiIntegration.php";



class ExchangeUseCase implements IUseCase {

    private $integration = null;

    private $requestedExchanges = array();

    public function __construct() {
        $this->integration = new ExchangeRateApiIntegration;
        $this->requestedExchanges = explode(",", $_ENV['CURRENCIES']);
    }

    public function process() {
        $response = $this->integration->latestRates();
        if(false !== $response) {
            $rates = $response->rates;
        
            $requiredRates = array();
            foreach($this->requestedExchanges as $currency) {
                try {
                    $requiredRates[$currency] = $rates->{$currency};
                } catch (Exception $e) {
                    $requiredRates[$currency] = null;
                }
            }

            $ret = array();
            foreach($requiredRates as $currency => $rate) {
                $ret["1$currency-EUR"] = $this->calculateEURValue($rate);
            }
            return $ret;
        }

        throw new Exception("Service unavailable");
    }

    private function calculateEURValue($exchange) {
        return number_format(1/$exchange, 4);
    }
}