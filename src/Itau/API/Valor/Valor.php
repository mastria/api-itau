<?php
namespace Itau\API\Valor;

use Itau\API\TraitEntity;

class Valor implements \JsonSerializable
{
    use TraitEntity;

    private string $valor_titulo;

    public function __construct($valor)
    {
        $this->valor_titulo = number_format($valor, 2, ".");
    }

    public function setValor($valor): self
    {
        $this->valor_titulo = number_format($valor, 2, ".");
        return $this;
    }
}