<?php

namespace Itau\API\Boleto;

use Itau\API\BaseResponse;

class BoletoResponse extends BaseResponse
{
    protected $valor;

    public function getValor()
    {
        return $this->valor;
    }
}