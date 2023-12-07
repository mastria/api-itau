<?php

namespace Itau\API;

class PixResponse extends BaseResponse
{
    private $txid;
    private $pixCopiaECola;

    public function Txid()
    {
        return $this->txid;
    }

    public function getPixCopiaECola()
    {
        return $this->pixCopiaECola;
    }
}