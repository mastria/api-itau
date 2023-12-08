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
    private DadosQrcode $dados_qrcode;


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

    private function setDadoBoleto(DadoBoleto $dado): self
    {
        $this->dado_boleto = $dado;
        return $this;
    }

    public function dadosQrCode(): DadosQrCode
    {
        $dado = new DadosQrCode();

        $this->setDadosQrCode($dado);

        return $dado;
    }

    private function setDadosQrCode(DadosQrCode $dado): self
    {
        $this->dados_qrcode = $dado;
        return $this;
    }
}