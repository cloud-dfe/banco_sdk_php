<?php

declare(strict_types=1);

namespace CloudDFe\BancoSdk\Crypto;

use RuntimeException;

/**
 * Crypto class for secure encryption and decryption.
 * Uses AES-256-GCM for authenticated encryption.
 */
readonly class Crypto
{
    private const string CIPHER = 'aes-256-gcm';

    /**
     * Encrypts the given plaintext using the provided key.
     *
     * @param string $plaintext The text to encrypt.
     * @param string $key The encryption key (must be 32 bytes for AES-256).
     * @return string The base64 encoded string containing IV, tag, and ciphertext.
     * @throws RuntimeException If encryption fails.
     */
    public static function encrypt(string $plaintext, string $key): string
    {
        if (strlen($key) !== 32) {
            throw new RuntimeException('A chave [Key] deve ter exatamente 32 bytes para o uso do algoritimo de criptografia AES-256.');
        }
        $ivLength = openssl_cipher_iv_length(self::CIPHER);
        $iv = openssl_random_pseudo_bytes($ivLength);
        $tag = '';
        $ciphertext = openssl_encrypt(
            $plaintext,
            self::CIPHER,
            $key,
            OPENSSL_RAW_DATA,
            $iv,
            $tag
        );
        if ($ciphertext === false) {
            throw new RuntimeException('A Encriptação Falhou.');
        }
        // Combine IV, Tag, and Ciphertext and encode to base64
        return base64_encode($iv . $tag . $ciphertext);
    }

    /**
     * Decrypts the given base64 encoded ciphertext using the provided key.
     *
     * @param string $encodedPayload The base64 encoded payload (IV + Tag + Ciphertext).
     * @param string $key The decryption key (must be 32 bytes for AES-256).
     * @return string The decrypted plaintext.
     * @throws RuntimeException If decryption fails or the payload is invalid.
     */
    public function decrypt(string $encryptedMsg, string $key): string
    {
        if (strlen($key) !== 32) {
            throw new RuntimeException('A chave [Key] deve ter exatamente 32 bytes para  o uso do algoritimo de criptografia AES-256.');
        }
        $payload = base64_decode($encryptedMsg, true);
        if ($payload === false) {
            throw new RuntimeException('Codificação base64 Inválida.');
        }
        $ivLength = openssl_cipher_iv_length(self::CIPHER);
        $tagLength = 16; // Default tag length for GCM in PHP

        if (strlen($payload) < ($ivLength + $tagLength)) {
            throw new RuntimeException('Comprimento do payload inválido.');
        }
        $iv = substr($payload, 0, $ivLength);
        $tag = substr($payload, $ivLength, $tagLength);
        $ciphertext = substr($payload, $ivLength + $tagLength);

        $plaintext = openssl_decrypt(
            $ciphertext,
            self::CIPHER,
            $key,
            OPENSSL_RAW_DATA,
            $iv,
            $tag
        );

        if ($plaintext === false) {
            throw new RuntimeException('Decriptação Falhou. Chave Inválida ou dados adulterados.');
        }
        return $plaintext;
    }
}