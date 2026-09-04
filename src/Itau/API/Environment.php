<?php
namespace Itau\API;

/**
 * Class Environment
 *
 * @package Itau\API
 */
class Environment
{

    private $apiPix;
    private $apiBolecode;
    private $apiAuth;
    private $apiBoleto;
    private $apiBoletoConsulta;

    /**
     *
     * @param string $api
     *
     */
    private function __construct($apiAuth, $apiPix, $apiBolecode, $apiBoleto, $apiBoletoConsulta)
    {
        $this->apiAuth = $apiAuth;
        $this->apiPix = $apiPix;
        $this->apiBolecode = $apiBolecode;
        $this->apiBoleto = $apiBoleto;
        $this->apiBoletoConsulta = $apiBoletoConsulta;
    }

    /**
     *
     * @return Environment
     */
    public static function production()
    {
        return self::custom(
            'https://sts.itau.com.br/api/oauth/token',
            'https://secure.gateway.api.itau/pix_recebimentos/v2',
            'https://secure.gateway.api.itau/pix_recebimentos_conciliacoes/v2',
            'https://api.gateway.itau.com.br/cash_management/v2',
            'https://secure.api.cloud.itau.com.br/boletoscash/v2'
        );
    }

    /**
     * Permite configurar manualmente as URLs de cada API, útil quando o Itaú
     * migra domínios (ex.: descomissionamento de secure.api.itau/api.itau.com.br
     * em favor de secure.gateway.api.itau/api.gateway.itau.com.br) e a aplicação
     * consumidora precisa sobrescrever os padrões sem esperar uma nova versão do SDK.
     *
     * @return Environment
     */
    public static function custom(
        string $apiAuth,
        string $apiPix,
        string $apiBolecode,
        string $apiBoleto,
        string $apiBoletoConsulta
    ) {
        return new Environment($apiAuth, $apiPix, $apiBolecode, $apiBoleto, $apiBoletoConsulta);
    }

    public function getApiPixUrl(): string
    {
        return $this->apiPix;
    }

    public function getApiBoleCodeUrl(): string
    {
        return $this->apiBolecode;
    }

    public function getApiBoletoUrl(): string
    {
        return $this->apiBoleto;
    }

    public function getApiBoletoConsultaUrl(): string
    {
        return $this->apiBoletoConsulta;
    }

    public function getApiUrlAuth(): string
    {
        return $this->apiAuth;
    }
}