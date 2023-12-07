<?php

namespace Itau\API;

class PixResponse extends BaseResponse
{
    protected $txid;
    protected $pixCopiaECola;

    public function Txid()
    {
        return $this->txid;
    }

    public function getPixCopiaECola()
    {
        return $this->pixCopiaECola;
    }
}