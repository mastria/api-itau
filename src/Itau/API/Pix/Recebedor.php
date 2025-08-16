<?php

namespace Itau\API\Pix;

use Itau\API\TraitEntity;

class Recebedor implements \JsonSerializable
{
    use TraitEntity;

    /**
     * Máximo de 200 caracteres
     */
    private ?string $logradouro;

    /**
     * Máximo de 200 caracteres
     */
    private ?string $cidade;

    /**
     * Máximo de 2 caracteres
     */
    private ?string $uf;

    /**
     * Máximo de 8 caracteres
     */
    private ?string $cep;

    /**
     *  Número do Documento Cadastro de Pessoa Física.
     * Deve ser um número de 11 dígitos.
     * Observação: Se preenchido, não enviar CNPJ.
     *
     * @var string
     */
    private ?string $cpf;

    /**
     * Número do Cadastro Nacional da Pessoa Jurídica.
     * Deve ser um número de 14 dígitos.
     * Observação: Se preenchido, não enviar CPF.
     *
     * @var string
     */
    private ?string $cnpj;

    /**
     * Nome do pagador da cobrança.
     * Máximo de 200 caracteres
     * Observação: Necessário preencher o campo CNPJ ou o campo CPF.
     *
     * @var string
     */
    private string $nome;

    public function __construct(
        ?string $cpf = null,
        ?string $cnpj = null,
        ?string $nome = null,
        ?string $logradouro = null,
        ?string $cidade = null,
        ?string $uf = null,
        ?string $cep = null
    ) {
        $this->cpf = $cpf;
        $this->cnpj = $cnpj;
        $this->setNome($nome);
        $this->setLogradouro($logradouro);
        $this->setCidade($cidade);
        $this->setUf($uf);
        $this->setCep($cep);
    }

    public function setCpf(string $cpf): self
    {
        $this->cpf = $cpf;
        return $this;
    }

    public function setCnpj(string $cnpj): self
    {
        $this->cnpj = $cnpj;
        return $this;
    }

    public function setNome(string $nome): self
    {
        if (strlen($nome) > 200) {
            throw new \InvalidArgumentException('Nome deve ter no máximo 200 caracteres');
        }
        $this->nome = $nome;
        return $this;
    }

    public function setLogradouro(?string $logradouro): self
    {
        if (strlen($logradouro) > 200) {
            throw new \InvalidArgumentException('Logradouro deve ter no máximo 200 caracteres');
        }
        $this->logradouro = $logradouro;
        return $this;
    }

    public function setCidade(?string $cidade): self
    {
        if (strlen($cidade) > 200) {
            throw new \InvalidArgumentException('Cidade deve ter no máximo 200 caracteres');
        }
        $this->cidade = $cidade;
        return $this;
    }

    public function setUf(?string $uf): self
    {
        if (strlen($uf) > 2) {
            throw new \InvalidArgumentException('UF deve ter no máximo 2 caracteres');
        }
        $this->uf = $uf;
        return $this;
    }

    public function setCep(?string $cep): self
    {
        if (strlen($cep) > 8) {
            throw new \InvalidArgumentException('CEP deve ter no máximo 8 caracteres');
        }

        if (!is_null($cep) && !ctype_digit($cep)) {
            throw new \InvalidArgumentException('CEP deve conter apenas números');
        }
        $this->cep = $cep;
        return $this;
    }
}
