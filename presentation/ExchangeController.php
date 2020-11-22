<?php
include_once 'BaseController.php';

/* This is the presentation layer. In this context, its only responsability is 
redirect the request to the proper use case and format its response, 
but it could have some request validations, filters, data format or another non-business rules */
class ExchangeController extends BaseController {
    public function exchange() {
        $useCaseResponse = $this->useCase->process();
        return $useCaseResponse;
    }

    public function recomendation() {
        $useCaseResponse = $this->useCase->process();
        return $useCaseResponse;
    }
}