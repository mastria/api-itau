<?php

namespace Itau\API;

class Transaction implements \JsonSerializable
{
    use TraitEntity;

    const STATUS_AUTHORIZED = "AUTHORIZED";

    const STATUS_CONFIRMED = "CONFIRMED";

    const STATUS_PENDING = "PENDING";
    
    const STATUS_WAITING = "WAITING";

    const STATUS_APPROVED = "APPROVED";

    const STATUS_CANCELED = "CANCELED";

    const STATUS_DENIED = "DENIED";

    const STATUS_ERROR = "ERROR";
}