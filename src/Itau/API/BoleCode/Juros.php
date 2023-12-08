<?php
namespace Itau\API\BoleCode;

use Itau\API\TraitEntity;
use JsonSerializable;

class Juros implements JsonSerializable
{
    use TraitEntity;

    const SEM_JUROS = '05';
    const PERCENTUAL_MENSAL = '90';

    private string $codigo_tipo_juros = '90';
    private string $percentual_juros = '100';

    public function setJuros($codigo, $percendual): self
    {
        $this->codigo_tipo_juros = $codigo;
        $this->percentual_juros = $percendual*100;
        return $this;
    }
}