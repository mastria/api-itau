<?php

namespace Itau\API\BoleCode;

use Itau\API\BaseResponse;

class BoleCodeResponse extends BaseResponse
{
    protected $env;
    /*protected $txid;
    protected $pixCopiaECola;

    public function getTxid()
    {
        return $this->txid;
    }*/

    public function getPixCopiaECola()
    {
        return $this->env;
    }
}