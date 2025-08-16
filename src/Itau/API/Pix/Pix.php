<?php

namespace Itau\API\Pix;

use Itau\API\TraitEntity;

class Pix implements \JsonSerializable
{
    use TraitEntity;

    private ?Calendario $calendario;
    private ?Devedor $devedor;
    private ?Recebedor $recebedor;
    private ?string $chave;
    private ?string $txid;
    private Valor $valor;

    public function __construct(?string $chave = null, ?string $valor = null, ?Calendario $calendario = null, ?Devedor $devedor = null, ?Recebedor $recebedor = null)
    {
        $this->chave = $chave;
        $this->valor = new Valor($valor);
        $this->calendario = $calendario;
        $this->devedor = $devedor;
        $this->recebedor = $recebedor;
    }

    public function setChave($chave): self
    {
        $this->chave = $chave;
        return $this;
    }

    public function setTxid($txid): self
    {
        $this->txid = $txid;
        return $this;
    }

    public function valor(): Valor
    {
        $valor = new Valor();
        $this->setValor($valor);
        return $valor;
    }

    public function setValor(Valor $valor): self
    {
        $this->valor = $valor;
        return $this;
    }

    public function setCalendario(Calendario $calendario): self
    {
        $this->calendario = $calendario;
        return $this;
    }

    /**
     * Tempo de vida da cobrança, especificado em segundos a partir da data de criação da cobrança
     * Apenas para Pix Imediato
     * @var integer
     */
    public function setExpiracao(int $expiracao): self
    {
        $this->calendario = new Calendario(null, null, $expiracao);
        return $this;
    }

    public function setDevedor(Devedor $devedor): self
    {
        $this->devedor = $devedor;
        return $this;
    }

    public function setRecebedor(Recebedor $recebedor): self
    {
        $this->recebedor = $recebedor;
        return $this;
    }
}
