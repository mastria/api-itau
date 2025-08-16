<?php

namespace Itau\API\Pix;

use Itau\API\TraitEntity;

class Calendario implements \JsonSerializable
{
    use TraitEntity;

    /**
     * Data de vencimento da cobrança.
     *
     * @var string
     */
    private ?string $dataDeVencimento;

    /**
     * Trata-se da quantidade de dias corridos após calendario.dataDeVencimento, em que a cobrança poderá ser paga.
     *
     * @var integer
     */
    private ?int $validadeAposVencimento;

    /**
     * Tempo de vida da cobrança, especificado em segundos a partir da data de criação da cobrança
     *
     * @var integer
     */
    private ?int $expiracao;

    /**
     * @param string $dataDeVencimento
     * @param int $validadeAposVencimento
     */
    public function __construct(?string $dataDeVencimento = null, ?int $validadeAposVencimento = 30, ?int $expiracao = 86400)
    {
        $this->dataDeVencimento = $dataDeVencimento;
        $this->validadeAposVencimento = $validadeAposVencimento;
        $this->expiracao = $expiracao;
    }

    public function setValidadeAposVencimento(int $validadeAposVencimento): self
    {
        $this->validadeAposVencimento = $validadeAposVencimento;
        return $this;
    }

    public function setExpiracao(int $expiracao): self
    {
        $this->expiracao = $expiracao;
        return $this;
    }
}
