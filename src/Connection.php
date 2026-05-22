<?php

declare(strict_types=1);

namespace CloudDFe\BancoSdk;

class Connection
{
    protected string $uri;
    protected int $timeout = 60;
    protected array $error = ['code' => null, 'message' => null];
    protected object $config;

    public function __construct(object $config)
    {
        $this->config = $config;
        $this->uri = $config->uri;
        $this->timeout = $config->timeout;
    }

    public function requestToken()
    {
        $payload = [
            'client_id' => $this->config->client_id,
            'client_secret' => $this->config->client_secret,
            'username' => $this->config->login,
            'password' => $this->config->senha,
            'grant_type' => 'password',
            'scope' => ''
        ];
        $method = 'POST';
        $route = '/oauth/token';
        $header = [
            'Content-Type: application/json',
            'Accept: application/json'
        ];
        return $this->send($method, $route, $payload, $header);
    }


    public function send(string $method, string $route, ?array $payload, ?array $header = null)
    {
        if (empty($header)) {
            $header = [
                'Content-Type: application/json',
                'Autorization: Bearer ' . $this->config->access_token,
                'x-api-token: ' . $this->config->x_api_token,
            ];
        }
        if (!empty($this->config->access_token) && $route === '/oauth/token') {
            $response = $this->requestToken();
            $this->config->access_token = $response->access_token;
        }
        $oCurl = curl_init();
        $options = [
            CURLOPT_URL => "{$this->uri}{$route}",
            CURLOPT_IPRESOLVE => CURL_IPRESOLVE_V4,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_HEADER => false,
            CURLOPT_CONNECTTIMEOUT => $this->timeout + 20,
            CURLOPT_TIMEOUT => $this->timeout,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_POSTREDIR => CURL_REDIR_POST_ALL,
            CURLOPT_SSL_VERIFYHOST => 0,
            CURLOPT_SSL_VERIFYPEER => 0,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => $method,
        ];
        if (!empty($header)) {
            $options[CURLOPT_HTTPHEADER] = $header;
        }
        if ($method === 'POST') {
            $options[CURLOPT_POSTFIELDS] = json_encode($payload);
        }
        curl_setopt_array($oCurl, $options);
        $response = curl_exec($oCurl);
        $this->error["message"] = curl_error($oCurl);
        $this->error["code"] = curl_errno($oCurl);
        $httpcode = curl_getinfo($oCurl, CURLINFO_HTTP_CODE);
        curl_close($oCurl);
        if ($httpcode != 200) {

        }
        return json_decode($response);
    }

}