<?php

namespace CloudDFe\BancoSdk;

use RuntimeException;

class Boleto extends Common
{
    public function gerarBoleto(array $dados)
    {
        if (empty($this->config->x_api_key)) {
            throw new RuntimeException('O campo x-api-key deve ser informado, pegar no cadastro do emitente.');
        }
        $doc = !empty($dados['pagador']['cnpj']) ?
            $dados['pagador']['cnpj'] :
            (!empty($dados['pagador']['cpf']) ?
                $dados['pagador']['cpf'] :
                '');
        $valor = (float)$dados['pagamento']['valor'] ?? 0;
        $identificacao = $dados['identificacao'] ?? '';
        $vencimento = $dados['pagamento']['data_vencimento'] ?? '';
        $hash = hash('sha256', "{$identificacao}|$doc|{$valor}|{$vencimento}");
        $data = json_encode($dados);
        $encriptedPayload = Crypto::encrypt($data, $this->config->secret_key);
        $payload = [
            'hash' => $hash,
            'payload' => $encriptedPayload
        ];
        return $this->conn->send('POST', 'charge', $payload);
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
