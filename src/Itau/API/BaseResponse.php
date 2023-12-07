<?php

namespace Itau\API;

class BaseResponse implements \JsonSerializable
{
    use TraitEntity;

    private $responseJSON;
    private $status_code;
    private $status;

    public function jsonSerialize()
    {
        return get_object_vars($this);
    }

    public function mapperJson($json)
    {
        if (is_array($json)) {
            array_walk_recursive($json, function ($value, $key) {

                if (property_exists($this, $key)) {
                    $this->$key = $value;
                }
            });
        }

        $this->setResponseJSON($json);

        return $this;
    }

    public function setResponseJSON($array)
    {
        $this->responseJSON = json_encode($array, JSON_PRETTY_PRINT);

        return $this;
    }

    public function setStatusCode($status_code)
    {
        $this->status_code = $status_code;

        return $this;
    }

    public function getStatusCode()
    {
        return $this->status_code;
    }

    public function setStatus($status)
    {
        $this->status = $status;

        return $this;
    }

    public function getStatus()
    {
        if ($this->status_code == 201) {
            $this->status = Transaction::STATUS_AUTHORIZED;
        } elseif ($this->status_code == 202) {
            $this->status = Transaction::STATUS_AUTHORIZED;
        } elseif ($this->status_code == 402) {
            $this->status = Transaction::STATUS_DENIED;
        } elseif ($this->status_code == 400) {
            $this->status = Transaction::STATUS_ERROR;
        } elseif ($this->status_code == 402) {
            $this->status = Transaction::STATUS_ERROR;
        } elseif ($this->status_code == 500) {
            $this->status = Transaction::STATUS_ERROR;
        }
    }
}