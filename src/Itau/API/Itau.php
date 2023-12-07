<?php
namespace Itau\API;

use Itau\API\Exception\ItauException;

/**
 * Class Itau
 *
 * @package Itau\API
 */
class Itau
{

    private string $client_id;
    private string $client_secret;
    private string $certificate;
    private string $certificateKey;
    private $environment;
    private $authorizationToken;
    private $keySession;

    private $debug = false;

    public function __construct(string $client_id, string $client_secret, string $certificate, string $certificateKey)
    {
        $this->setClientId($client_id);
        $this->setClientSecret($client_secret);
        $this->setCertificate($certificate);
        $this->setCertificateKey($certificateKey);
        $this->setEnvironment(Environment::production());
        $this->setKeySession(session_status());
    }

    /**
     *
     * @return string
     */
    public function getClientId()
    {
        return $this->client_id;
    }

    /**
     *
     * @param string $client_id
     */
    public function setClientId($client_id)
    {
        $this->client_id = (string) $client_id;

        return $this;
    }

    /**
     *
     * @return mixed
     */
    public function getClientSecret()
    {
        return $this->client_secret;
    }

    /**
     *
     * @param mixed $client_secret
     */
    public function setClientSecret($client_secret)
    {
        $this->client_secret = (string) $client_secret;

        return $this;
    }

    public function getCertificate()
    {
        return $this->certificate;
    }

    public function setCertificate($certificate)
    {
        $this->certificate = (string) $certificate;

        return $this;
    }

    public function getCertificateKey()
    {
        return $this->certificateKey;
    }

    public function setCertificateKey($certificateKey)
    {
        $this->certificateKey = (string) $certificateKey;

        return $this;
    }

    public function getEnvironment(): Environment
    {
        return $this->environment;
    }

    public function setEnvironment(Environment $environment): self
    {
        $this->environment = $environment;

        return $this;
    }

    /**
     *
     * @return mixed
     */
    public function getAuthorizationToken()
    {
        return $this->authorizationToken;
    }

    /**
     *
     * @param mixed $authorizationToken
     */
    public function setAuthorizationToken($authorizationToken)
    {
        $this->authorizationToken = (string) $authorizationToken;

        return $this;
    }

    /**
     *
     * @return mixed
     */
    public function getKeySession()
    {
        return $this->keySession;
    }

    /**
     *
     * @param mixed $keySession
     */
    public function setKeySession($keySession)
    {
        $this->keySession = (string) $keySession;
    }

    /**
     *
     * @return bool|null
     */
    public function getDebug()
    {
        return $this->debug;
    }

    /**
     *
     * @param bool|null $debug
     */
    public function setDebug($debug = false)
    {
        $this->debug = $debug;

        return $this;
    }

    public function pix(Pix $pix): BaseResponse
    {
        try{
            if ($this->debug) {
                print $pix->toJSON();
            }

            $request = new Request($this);
            $response = $request->post($this, "{$this->getEnvironment()->getApiPixUrl()}/cob", $pix->toJSON());
           
            $pixResponse = new PixResponse();
            // Add fields do not return in response
            $pixResponse->mapperJson($pix->toArray());
            // Add response fields
            $pixResponse->mapperJson($response);
            return $pixResponse;

        } catch (\Exception $e) {
            return $this->generateErrorResponse($e);
        }
    }

    private function generateErrorResponse($e)
    {
        $error = new BaseResponse();
        $error->mapperJson(json_decode($e->getMessage(), true));
        
        if (empty($error->getStatus())) {
            $error->setStatus(Transaction::STATUS_ERROR);
        }
        
        return $error;
    }
}