<?php
namespace Itau\API\BoleCode;

use Itau\API\TraitEntity;
use JsonSerializable;

class Multa implements JsonSerializable
{
    use TraitEntity;

    const SEM_MULTA = '03';
    const PERCENTUAL = '02';

    private string $codigo_tipo_multa = '02';
    private string $percentual_multa = '200';

    public function setMulta($codigo, $percendual): self
    {
        $this->codigo_tipo_multa = $codigo;
        $this->percentual_multa = $percendual*100;
        return $this;
    }
}