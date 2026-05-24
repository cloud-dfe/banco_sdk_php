<?php

namespace CloudDFe\BancoSdk;

use RuntimeException;

class Boleto extends Common
{
    /**
     * @param array $dados
     * @return \stdClass
     */
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

    /**
     * @param array $dados
     * @return \stdClass
     */
    public function consultaBoleto(array $dados)
    {
        $identificacao = $dados['identificacao'] ?? '';
        return $this->conn->send('GET', "charge/{$identificacao}", []);
    }

    public function alteraBoleto(array $dados)
    {
        if (empty($this->config->x_api_key)) {
            throw new RuntimeException('O campo x-api-key deve ser informado, pegar no cadastro do emitente.');
        }
        $data = json_encode($dados);
        $encriptedPayload = Crypto::encrypt($data, $this->config->secret_key);
        $payload = [
            'payload' => $encriptedPayload
        ];
        return $this->conn->send('PUT', 'charge', $payload);
    }

    /**
     * @param array $dados
     * @return \stdClass
     */
    public function cancelaBoleto(array $dados)
    {
        if (empty($this->config->x_api_key)) {
            throw new RuntimeException('O campo x-api-key deve ser informado, pegar no cadastro do emitente.');
        }
        $data = json_encode($dados);
        $encriptedPayload = Crypto::encrypt($data, $this->config->secret_key);
        $payload = [
            'payload' => $encriptedPayload
        ];
        return $this->conn->send('DELETE', 'charge', $payload);
    }

    /**
     * @param array $dados
     * @return \stdClass
     */
    public function consultaEventoBoleto(array $dados)
    {
        $identificacao = $dados['identificacao'] ?? '';
        $evento_id = $dados['evento_id'] ?? '';
        return $this->conn->send('GET', "charge/{$identificacao}/{$evento_id}", []);
    }
}
