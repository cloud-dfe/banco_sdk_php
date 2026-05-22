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
            throw new RuntimeException('Key must be exactly 32 bytes for AES-256.');
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
            throw new RuntimeException('Encryption failed.');
        }
        // Combine IV, Tag, and Ciphertext and encode to base64
        return base64_encode($iv . $tag . $ciphertext);
    }
}