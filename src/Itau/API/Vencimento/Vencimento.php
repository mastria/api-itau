<?php
namespace Itau\API\Vencimento;

use Itau\API\TraitEntity;

class Vencimento implements \JsonSerializable
{
    use TraitEntity;

    private string $data_vencimento;


    public function setDataVencimento($vencimento): self
    {
        $this->data_vencimento = $vencimento;
        return $this;
    }
}