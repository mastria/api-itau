<?php

namespace Itau\API\BoleCode;

use Itau\API\TraitEntity;
use JsonSerializable;

class Endereco implements JsonSerializable
{
    use TraitEntity;

    private string $nome_logradouro;
    private string $nome_bairro;
    private string $nome_cidade;
    private string $sigla_UF;
    private string $numero_CEP;
    private string $complemento;
    private string $numero;

    public function setEndereco(
        string $rua, string $numero, string $complemento, string $bairro, string $cidade, string $uf, string $cep
    ): self
    {
        $this->nome_logradouro = mb_substr($rua, 0, 45);
        $this->nome_bairro = mb_substr($bairro, 0, 15);
        $this->nome_cidade = mb_substr($cidade, 0, 20);
        $this->sigla_UF = mb_substr($uf, 0, 2);
        $this->numero_CEP = preg_replace("/[^0-9]/", "", $cep);
        $this->complemento = mb_substr($complemento, 0, 10);
        $this->numero = $numero;

        return $this;
    }
}