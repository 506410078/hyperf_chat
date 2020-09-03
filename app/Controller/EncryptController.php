<?php

declare(strict_types=1);

namespace App\Controller;

header('Access-Control-Allow-Origin:*');
class EncryptController extends AbstractController
{
    protected $method = 'AES-128-CBC';
    protected $secret_key = '1234567891234567';
    protected $options = OPENSSL_RAW_DATA;


    function __construct()
    {
        parent::__construct();
    }

    public function lists()
    {
        $list = [
            'test' => 'a',
            'a' => 'b',
        ];
//        $list = 'test';
        $iv = '1234567891234567';
        $data = $this->en($list,$iv);
        return $data;
    }

    public function en($data,$iv='') {
        if(empty($iv)){
            $ivlen = openssl_cipher_iv_length($this->method);
            $iv = openssl_random_pseudo_bytes($ivlen);
            $iv = bin2hex($iv);
            if(strlen($iv) > $ivlen) {
                $iv = substr($iv, 0, $ivlen);
            }
        }
        if(is_array($data)) {
            $data = json_encode($data);
        }
        $sign = openssl_encrypt($data, $this->method, $this->secret_key, $this->options, $iv);
        $sign = URLencode(base64_encode($sign));

        return array('sign' => $sign, 'iv' => $iv);
    }

    public function de($str,$iv = '') {
//        $arr = [
//            'str' =>$str,
//            'iv' => $iv,
//        ];
//        return $arr;
        
        $str = URLdecode($str);
        $data = openssl_decrypt(base64_decode($str), $this->method, $this->secret_key, $this->options, $iv);
        return json_encode($data);
    }


}
