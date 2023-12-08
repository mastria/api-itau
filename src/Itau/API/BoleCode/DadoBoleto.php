<?php

namespace Itau\API\BoleCode;

use Itau\API\TraitEntity;

class DadoBoleto implements \JsonSerializable
{
    use TraitEntity;

    const ESPECIE_DM = '01';
    const ESPECIE_DS = '08';

    private string $descricao_instrumento_cobranca = "boleto_pix";
    private int $codigo_carteira = 109;
    private string $valor_total_titulo;
    private string $codigo_especie;
    private string $data_emissao;
    private string $texto_seu_numero;
    private Pagador $pagador;
    private DadosIndividuaisBoleto $dados_individuais_boleto;
    private Juros $juros;
    private Multa $multa;


    public function __construct()
    {
        $this->data_emissao = date("Y-m-d");
    }

    public function setDados(string $valor, string $codigoEspecia,string $numero): self
    {
        $this->valor_total_titulo = round($valor*100);
        $this->codigo_especie = $codigoEspecia;
        $this->texto_seu_numero = $numero;
        return $this;
    }

    public function pagador(): Pagador
    {
        $pagador = new Pagador();

        $this->setPagador($pagador);

        return $pagador;
    }

    public function setPagador(Pagador $pagador): self
    {
        $this->pagador = $pagador;
        return $this;
    }
}