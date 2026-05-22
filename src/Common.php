<?php

namespace CloudDFe\BancoSdk;

class Common
{

    protected object $config;
    protected $conn;
    protected $urls = [
        1 => 'http://127.0.0.1:8000',
        2 => 'http://127.0.0.1:8000',
    ];

    public function __construct(array $config)
    {
        $this->config = (object) $config;
        $this->config->uri = $this->urls[2];
        if ($this->config->producao) {
            $this->config->uri = $this->urls[1];
        }
        $this->config->x_api_token = $config['x_api_token'] ?? '';
        $this->conn = new Connection($this->config);
    }



}