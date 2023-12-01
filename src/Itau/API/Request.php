<?php
namespace Itau\API;

use Exception;
use Itau\API\Exception\ItauException;

/**
 * Class Request
 *
 * @package Itau\API
 */
class Request
{

    /**
     * Base url from api
     *
     * @var string
     */
    private $baseUrl = '';

    private $authUrl = '';

    /**
     * Request constructor.
     *
     * @param Itau $credentials
     * TODO create local variable to $credentials
     */
    public function __construct(Itau $credentials)
    {
        $this->baseUrl = $credentials->getEnvironment()->getApiUrl();

        if (! $credentials->getAuthorizationToken()) {
            $this->auth($credentials);
        }
    }

    /**
     *
     * @param Itau $credentials
     * @return Itau
     * @throws Exception
     */
    public function auth(Itau $credentials)
    {
        try {
            
            $endpoint = $credentials->getEnvironment()->getApiUrlAuth();
            $headers = [
                'Content-Type: application/x-www-form-urlencoded',
                'x-itau-correlationID: 2',
                'x-itau-flowID: 1'
            ];

            $request = [
                'grant_type' => 'client_credentials',
                'client_id' => $credentials->getClientId(),
                'client_secret' => $credentials->getClientSecret()
            ];

            $curl = curl_init();

            curl_setopt_array($curl, [
                CURLOPT_URL => $endpoint,
                CURLOPT_PORT => 443,
                CURLOPT_VERBOSE => 1,
                CURLOPT_HTTPHEADER => $headers,
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_CUSTOMREQUEST => 'POST',
                CURLOPT_POSTFIELDS => http_build_query($request),
                CURLOPT_SSLCERT => $credentials->getCertificate(),
                CURLOPT_SSLKEY => $credentials->getCertificateKey(),
                CURLOPT_CAINFO => $credentials->getCertificate(),
                CURLOPT_SSL_VERIFYPEER => 0
            ]);

            $response = curl_exec($curl);

            curl_close($curl);
            var_dump(['response' => $response]);
        } catch (Exception $e) {
            throw new ItauException($e->getMessage(), 100);
        }
    }
}
