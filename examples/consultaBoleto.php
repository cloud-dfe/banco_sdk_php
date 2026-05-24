<?php
error_reporting(E_ALL);
ini_set('display_errors', 'On');
require_once '../bootstrap.php';

use CloudDFe\BancoSdk\Boleto;

$config = [
    'timeout' => 60,
    'production' => false,
    'auth' => [
        'client_id' => '019e09d4-b609-7157-ab53-b92cf5f57d26',
        'client_secret' => 'zkRcRnv68vTrLh67wCDBmrpaoNLVsDa7owquImRm',
        'login' => "teste@gmail.com",
        'senha' => '2222',
    ],
    'secret_key' => 'fe7017ae-2299-4836-a3cf-b322a559', // chave de escriptacao da softhouse
    'access_token' => '', // token recuperado do oauth2
    'x-api-key' => 'fe7017ae-2299-4836-a3cf-b322a55946e1', // token do emitente
];


$dados = [
    "identificacao" => "13",
];

$bol = new Boleto($config);

$resp = $bol->consultaBoleto($dados);

var_dump($resp);
