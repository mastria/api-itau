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
        $this->nome_logradouro = $rua;
        $this->nome_bairro = $bairro;
        $this->nome_cidade = $cidade;
        $this->sigla_UF = $uf;
        $this->numero_CEP = $cep;
        $this->complemento = $complemento;
        $this->numero = $numero;

        return $this;
    }
}