<?php

use CloudDFe\BancoSdk\Auth;

error_reporting(E_ALL);
ini_set('display_errors', 'On');
require_once '../bootstrap.php';


$config = [
    'timeout' => 60, //opcional
    'producao' => false,
    'auth' => [
        'client_id' => '019e09d4-b609-7157-ab53-b92cf5f57d26',
        'client_secret' => 'zkRcRnv68vTrLh67wCDBmrpaoNLVsDa7owquImRm',
        'login' => "cperin20@gmail.com",
        'senha' => '2222',
    ],
    'secret_key' => '', // chave de escriptacao da softhouse
    'access_token' => '', // token recuperado do oauth2
    'x-api-token' => '', // token do emitente
];

$auth = new Auth($config);

$resp = $auth->getAccessToken($config);