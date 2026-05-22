<?php
error_reporting(E_ALL);
ini_set('display_errors', 'On');
require_once '../bootstrap.php';

use CloudDFe\BancoSdk\Auth;

$config = [
    'timeout' => 60, //opcional
    'producao' => false,
    'auth' => [
        'client_id' => '019e09d4-b609-7157-ab53-b92cf5f57d26',
        'client_secret' => 'zkRcRnv68vTrLh67wCDBmrpaoNLVsDa7owquImRm',
        'refresh_token' => 'def50200d2d4a329ff82fe32724d160de2532fe49a8e820ef42b7b9fc3b03eb32c55ec610db1df930463e42ce8710d6d2b72d15ae1580258d5e82563c2c62324d7169502c5c6ad8b0a862c211917f1d2535fd60c8d1a56253a8094eb9dccbe9a29d87eb08f83419dba0f135a55db1afd552c8b2843ab0982884f3e58f4c97df81f1a89cdfdf9ac02c25216de8afe84300220eb2b134494b895edcc3a6eb0917ee70efdc1fdea6809211047ea67ab3386e6ca9db68c3416cf337ed05e8f41d1ec0a71d33ba0c811a65f43cc7d63176cf750fa72ebb1deb5e3937f8ba62b0db5fa9781271495f933f7d76dbe0f8a0bdf8b3bb7c7884e4c075d3e9d40b1cbf0feba362f1dbc24e6ded046dc8ed583c6662e18a2e22b64d5a75b8965baabafcc806ca29e8e3bb4962d6401c043965ab5017600f80f7c8b90246419e6386ef4245e39ee51452a8e3d7902034a208d199f17d4346836cbf902874e0ad3994de377f34d2e6d5ac39a4cc773b8c104ce7d9bcaf4eb72fef9c9f5d7c8a95c27975e214251e30423bb107c',
        'login' => "cperin20@gmail.com",
        'senha' => '2222',
    ],
    'secret_key' => '', // chave de escriptacao da softhouse
    'access_token' => '', // token recuperado do oauth2
    'x-api-token' => '', // token do emitente
];

$auth = new Auth($config);

$resp = $auth->getAccessToken();




/*
Caso a solicitação tenha sucesso será retornado o seguinte objeto:
{
    "token_type": "Bearer",
    "expires_in": 1296000,
    "access_token": "eyJ0eXAiOiJKV1QiLCJhbGciOiJSUzI1NiJ9.eyJhdWQiOiIwMTllMDlkNC1iNjA5LTcxNTctYWI1My1iOTJjZjVmNTdkMjYiLCJqdGkiOiJjNzUyYjExNGQwOWQ1MWRhOTg5YjdhOGY2YTA0YzA0YWViNWRkNDU4OGRlZGYzMzhkMjI3ZDIxNWUxNDE5MDZhMThhYWRjYTkwYmY0ZTU1NCIsImlhdCI6MTc3OTQ3NzcyMi43OTQ5NzMsIm5iZiI6MTc3OTQ3NzcyMi43OTQ5NzUsImV4cCI6MTc4MDc3MzcyMi43ODgxOTgsInN1YiI6IjIiLCJzY29wZXMiOltdfQ.KYPdMxccVQ7BXwmZD7I74y65pzrDsbKuKD_XFIVajt9MUHYOpF_LGFsvrO-wgpK2FJPGxytr2I-3p-CenZqLPsqqXimNfg1jZx9kvx6KOYma1cehxAlredaUtxygxTUlAJ4L6GkWE6qa9bQqjnQUr1e96wVfG-wc4kXv7GBdsK-WjjMEik8pWZjGumeSZxiFmfGhRslk2rgs6G56gNZKtMC4ZNvnxmChau4a9Zarjl8HDVJgztkkej9FFNxEjCOB_ISnjJiPsRtTvlpE5pYRMdpO5ZZzSO2DaPU6kgYpzAFgAuhlkjniIiPiF1lTwwmIt25SHTYwnmH3r4i-aMG9f38s_0NFl7lmz4b7X_uyCKZUv9tVTRZ27wYWIa0KDjVHg3CJDK4HjU5Qn1AZylMkCK6J0Bbt6QllhhiZJAccgCUQJpTbUJn6qHrhPZu9jxV6c2isEk3MH9dj5FIFNL6cs_BOD9HfFxK26Qlh2__MJkaW2TGefCGwkZu9d3Ph155P1CJZVcN90pgErD4vohn4jck2nD2b3GvIKVrDljoLuL86eN0TmTX3vxR-mfc1apxsZm8795mRNuIMXatluAiDwVrYZm1zW-yC7ICtxF9EqiZAp24W4ggAVO5FLifMvbCld7jKpD4fsO8gc9Xyit5EuprYnJaRt12VOZMzxUozA7g",
    "refresh_token": "def50200d2d4a329ff82fe32724d160de2532fe49a8e820ef42b7b9fc3b03eb32c55ec610db1df930463e42ce8710d6d2b72d15ae1580258d5e82563c2c62324d7169502c5c6ad8b0a862c211917f1d2535fd60c8d1a56253a8094eb9dccbe9a29d87eb08f83419dba0f135a55db1afd552c8b2843ab0982884f3e58f4c97df81f1a89cdfdf9ac02c25216de8afe84300220eb2b134494b895edcc3a6eb0917ee70efdc1fdea6809211047ea67ab3386e6ca9db68c3416cf337ed05e8f41d1ec0a71d33ba0c811a65f43cc7d63176cf750fa72ebb1deb5e3937f8ba62b0db5fa9781271495f933f7d76dbe0f8a0bdf8b3bb7c7884e4c075d3e9d40b1cbf0feba362f1dbc24e6ded046dc8ed583c6662e18a2e22b64d5a75b8965baabafcc806ca29e8e3bb4962d6401c043965ab5017600f80f7c8b90246419e6386ef4245e39ee51452a8e3d7902034a208d199f17d4346836cbf902874e0ad3994de377f34d2e6d5ac39a4cc773b8c104ce7d9bcaf4eb72fef9c9f5d7c8a95c27975e214251e30423bb107c"
}
*/



var_dump($resp);
