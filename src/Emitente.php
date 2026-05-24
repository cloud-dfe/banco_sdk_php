<?php

namespace CloudDFe\BancoSdk;

class Emitente extends Common
{
    /**
     * @param array $dados
     * @return \stdClass
     */
    public function cria(array $dados)
    {
        return $this->conn->send('POST', 'emitente', $dados);
    }

    /**
     * @param array $dados
     * @return \stdClass
     */
    public function atualiza(array $dados)
    {
        return $this->conn->send('PUT', 'emitente', $dados);
    }
}
