<?php

declare(strict_types=1);

namespace CloudDFe\BancoSdk;

class Connection
{
    protected string $uri = '';
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
        if (!empty($this->config->refresh_token)) {

        }
        $payload = [
            'client_id' => $this->config->auth->client_id,
            'client_secret' => $this->config->auth->client_secret,
            'username' => $this->config->auth->login ?? '',
            'password' => $this->config->auth->senha ?? '',
            'grant_type' => 'password',
            'scope' => ''
        ];
        //se foi passado no payload o refresh token não é necessário nem o login nem a senha
        if (!empty($this->config->refresh_token)) {
            $payload['refresh_token'] = $this->config->refresh_token;
            unset($payload['username']);
            unset($payload['password']);
        }
        $method = 'POST';
        $route = 'oauth/token';
        $header = [
            'Content-Type: application/json',
            'Accept: application/json'
        ];
        return $this->request($method, $route, $payload, $header);
    }


    public function send(string $method, string $route, ?array $payload, ?array $header = null)
    {
        if (empty($this->config->access_token)) {
            $response = $this->requestToken();
            $this->config->access_token = $response->access_token;
        }
        if (empty($header)) {
            $header = [
                'Content-Type: application/json',
                'Authorization: Bearer ' . $this->config->access_token,
                'x-api-key: ' . $this->config->x_api_key,
            ];
        }
        return $this->request($method, $route, $payload, $header);
    }

    public function request(string $method, string $route, ?array $payload, ?array $header = null)
    {
        $oCurl = curl_init();
        $options = [
            CURLOPT_URL => "{$this->uri}/{$route}",
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
