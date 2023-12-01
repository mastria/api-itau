<?php

namespace Itau\API;

class Transaction implements \JsonSerializable
{
    use TraitEntity;

    private string $amount;


    public function getAmount(): string
    {
        return $this->amount;
    }

    public function setAmount(string $amount): self
    {
        $this->amount = (int) (string) ($amount * 100);

        return $this;
    }
}