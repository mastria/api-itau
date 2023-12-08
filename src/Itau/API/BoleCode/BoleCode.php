<?php
namespace Itau\API\BoleCode;

use Itau\API\TraitEntity;

class BoleCode implements \JsonSerializable
{
    use TraitEntity;

    const ETAPA_TESTE = "simulacao";
    const ETAPA_EFETIVO = "efetivacao";

    private string $etapa_processo_boleto;
    private Beneficiario $beneficiario;
    private DadoBoleto $dado_boleto;


    public function setEtapaProcessoBoleto($etapa): self
    {
        $this->etapa_processo_boleto = $etapa;
        return $this;
    }

    public function beneficiario(): Beneficiario
    {
        $beneficiario = new Beneficiario();

        $this->setBeneficiario($beneficiario);

        return $beneficiario;
    }

    public function getBeneficiario(): Beneficiario
    {
        return $this->beneficiario;
    }

    public function setBeneficiario(Beneficiario $beneficiario): self
    {
        $this->beneficiario = $beneficiario;
        return $this;
    }

    public function dadoBoleto(): DadoBoleto
    {
        $dado = new DadoBoleto();

        $this->setDadoBoleto($dado);

        return $dado;
    }

    public function getDadoBoleto(): DadoBoleto
    {
        return $this->dado_boleto;
    }

    public function setDadoBoleto(DadoBoleto $dado): self
    {
        $this->dado_boleto = $dado;
        return $this;
    }
}