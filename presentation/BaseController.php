<?php
include_once "useCase/IUseCase.php";

class BaseController {
    protected $useCase = null;
    
    public function __construct(IUseCase $useCase) {
        $this->useCase = $useCase;
    }
}