<?php

namespace Itau\API\BoleCode;

class Beneficiario implements \JsonSerializable
{
    use TraitEntity;

    private $id_beneficiario;

    public function setIdBeneficiario($agencia, $contaComDigito): self
    {
        $this->id_beneficiario = $agencia.str_pad($contaComDigito, 8, '0', STR_PAD_LEFT);
        return $this;
    }

    public function getIdBeneficiario(): string
    {
        return $this->id_beneficiario;
    }
}