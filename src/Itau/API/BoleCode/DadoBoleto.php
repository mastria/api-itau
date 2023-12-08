<?php

namespace Itau\API\BoleCode;

use Itau\API\TraitEntity;

class DadoBoleto implements \JsonSerializable
{
    use TraitEntity;

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

}