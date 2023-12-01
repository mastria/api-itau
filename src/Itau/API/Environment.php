<?php
namespace Itau\API;

/**
 * Class Environment
 *
 * @package Itau\API
 */
class Environment
{

    private $api;
    private $apiAuth;

    /**
     *
     * @param string $api
     *
     */
    private function __construct($api, $apiAuth)
    {
        $this->api = $api;
        $this->apiAuth = $apiAuth;
    }

    /**
     *
     * @return Environment
     */
    public static function production()
    {
        return new Environment(
            'https://secure.api.itau/pix_recebimentos_conciliacoes/v2',
            'https://sts.itau.com.br/api/oauth/token/api/oauth/token'
        );
    }

    /**
     * Gets the environment's Api URL
     *
     * @return string the Api URL
     */
    public function getApiUrl()
    {
        return $this->api;
    }

    public function getApiUrlAuth(): string
    {
        return $this->apiAuth;
    }
}