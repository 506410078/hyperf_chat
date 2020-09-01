<?php

declare(strict_types=1);

namespace App\Controller;

class EncryptController extends AbstractController
{

    private static $aes_key = "asdasdasda";

    function __construct()
    {
        $data = $this->request->getBody();
        openssl_encrypt($data,'AES-128-ECB',self::$aes_key,OPENSSL_RAW_DATA);
    }
}
