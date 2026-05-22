<?php

namespace CloudDFe\BancoSdk;

use CloudDFe\BancoSdk\Crypto\Crypto;

class Boleto extends Common
{
    public function gerarBoleto(array $dados)
    {
        $doc = $dados['pagador']['cnpj'] ?? ($dados['pagador']['cpf'] ?? '');
        $valor = (float) $dados['pagamento']['valor'] ?? 0;
        $identificacao = $dados['identificacao'] ?? '';
        $vencimento = $dados['vencimento'] ?? '';
        $hash = hash('sha256', "{$identificacao}|$doc|{$valor}{$vencimento}");
        $data = json_encode($dados);
        $encriptedPayload = Crypto::encrypt($data, $this->config->secret_key);
        $payload = [
            'hash' => $hash,
            'payload' => $encriptedPayload
        ];
        $method = 'POST';
        $route = '/boleto';
        return $this->conn->send($method, $route, $payload);
    }

    public function consultaBoleto()
    {

    }

    public function alteraBoleto()
    {

    }

    public function cancelaBoleto()
    {

    }

    public function consultaEventoBoleto()
    {

    }
}