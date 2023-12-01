<?php

namespace Itau\API;

class Valor implements \JsonSerializable
{
    use TraitEntity;

    private string $original;

    public function setOriginal(string $original): self
    {
        $this->original = (int) (string) ($original * 100);
        return $this;
    }

    public function getOriginal(): string
    {
        return $this->original;
    }
}