<?php

namespace CloudDFe\BancoSdk;

class Common
{

    protected object $config;
    protected $conn;
    protected $urls = [
        1 => 'http://localhost:8002/api/v1',
        2 => 'http://localhost:8002/api/v1',
    ];

    public function __construct(array $config)
    {
        $this->config = json_decode(json_encode($config));
        $this->config->uri = $this->urls[2];
        if ($this->config->producao) {
            $this->config->uri = $this->urls[1];
        }
        $this->config->x_api_token = $config['x_api_token'] ?? '';
        $this->conn = new Connection($this->config);
    }
}
