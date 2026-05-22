<?php

namespace CloudDFe\BancoSdk;

class Auth extends Common
{
    public function getAccessToken()
    {
        //'auth' => [
        //        'client_id' => '2191e682-3d92-484e-b8d5-e7a3c826119a',
        //        'client_secret' => '1da65327-0568-4139-a80b-0ff137d5922a',
        //        'login' => '',
        //        'senha' => '',
        //    ],
        return $this->conn->requestToken();

    }
}