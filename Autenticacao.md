# Autenticação

A autenticação é o primeiro passo para acessar o sistema, e obter o token de acesso que lhe permitirá realizar quaisquer operações desejada.
Na primeira autenticação são necessários os seguintes dados:

- login - seu email usado no cadastro da aplicação
- senha - a senha que você escolheu
- client_id - fornecido pelo IntegraBancos após o cadastro
- client_secret  - fornecido pelo IntegraBancos após o cadastro

A classe Auth é usada para obter o token de acesso.


A autenticação retorna um objeto com os seguintes dados:

```json
{
    "token_type": "Bearer",
    "expires_in": 1296000,
    "access_token": "eyJ0eXAiOiJKV1QiLCJhbGciOiJSUzI1NiJ9.eyJhdWQiOiIwMTllMDlkNC1iNjA5LTcxNTc....",
    "refresh_token": "def50200d2d4a329ff82fe32724d160de2532fe49a8e820ef42b7b9fc3b03eb32c55ec6...."
}
```
É recomendável que você salve os dados em tabela ou arquivo com os dados de acesso a api, MAS com SEGURANÇA, ou seja sem acesso fácil e especialmente usando encriptação nos dados sensíveis.

> NOTA IMPORTANTE: Caso os dados sensíveis vazem, o "hacker" poderá acessar o sistema, e gerar múltiplos boletos/Pix causando grandes dados ao seu cliente.

Para encriptação ou decriptação dos dados no seu sistema, pode usar a classe contida neste sdk Crypto::class.

Já a chave sua chave local para esse processo, deve ser mantida segura em um arquivo .env ou similar.

Ex. em tabela:

expires_in = 1296000 segundos = 15 dias, pode transformar isso em um datetime usando o 
```php
$valid_at = Carbon::now()->addSeconds($expires_in)->format('Y-m-d H:i:s');

//ex. de encriptação
$chave = random_bytes(32); //retorna dados binarios, para salvar converter com base64_encode

// salvar no .env
$crypto_key = base64_encode($chave);

//decriptar
$chave = base64_decode($crypto_key);

$password = Crypto::encrypt($password, $chave); //encripta a senha e retorna o valor pronto para ser salvo na base de dados
```

| Field         |   Type   | Length |  Format   |
|:--------------|:--------:|:------:|:---------:|
| id            |   int    |   11   |   Plain   |
| login         |  string  |  255   |   Plain   |
| password      |  string  |  255   | encrypted |
| access_token  |   text   |  255   | encrypted |
| valid_at     | datetime |        |   Plain   |
| refresh_token |   text   |  255   | encrypted |
| created_at    | datetime |  255   |   Plain   |
| updated_at    | datetime |  255   |   Plain   |

