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

    /**
     *
     * @param string $api
     *
     */
    private function __construct($apiAuth, $apiPix, $apiBolecode)
    {
        $this->apiAuth = $apiAuth;
        $this->apiPix = $apiPix;
        $this->apiBolecode = $apiBolecode;
    }

    /**
     *
     * @return Environment
     */
    public static function production()
    {
        return new Environment(
            'https://sts.itau.com.br/api/oauth/token/api/oauth/token',
            'https://secure.api.itau/pix_recebimentos/v2',
            'https://secure.api.itau/pix_recebimentos_conciliacoes/v2',
        );
    }

    public function getApiPixUrl(): string
    {
        return $this->apiPix;
    }

    public function getApiBoleCodeUrl(): string
    {
        return $this->apiBolecode;
    }

    public function getApiUrlAuth(): string
    {
        return $this->apiAuth;
    }
}