<?php

declare(strict_types=1);

namespace App\Controller;

class EncryptController extends AbstractController
{

    private static $aes_key = "asdasdasda";

    function __construct()
    {
        parent::__construct();
    }

    function index($id)
    {
        $data = $this->request->all();
        return [
            'id' =>$id,
//            'name' => $name,
        'data' => $data,
        ];
        $user = $this->request->input('user', 'Hyperf');
        $method = $this->request->getMethod();

        return [
            'method' => $method,
            'message' => "Hello ya hello  {$user}. {$id} .",
        ];

    }
}
