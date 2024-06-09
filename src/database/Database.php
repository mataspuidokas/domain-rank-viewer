<?php
/**
 * @package DomainRankViewer
 */

 namespace Src\Database;

 use Src\Enums\DatabaseEnum;
 
 defined('ABSPATH') || exit;

 class Database
 {  
    /**
     * Encrypt data using the encryption key
     *
     * @param string $data The data to encrypt
     * @param string $encryptionKey The encryption key
     */
    public static function encrypt(string $data, string $encryptionKey): string|false
    {
        $iv = openssl_random_pseudo_bytes(openssl_cipher_iv_length('aes-256-cbc'));
        $encryptedData = openssl_encrypt($data, 'AES-256-CBC', $encryptionKey, 0, $iv);
        
        return base64_encode($iv . $encryptedData);
    }

    /**
     * Decrypt data using the encryption key
     *
     * @param string $data The data to decrypt
     * @param string $encryptionKey The encryption key
     */
    public static function decrypt(string $data, string $encryptionKey): string|false
    {
        $decodedData = base64_decode($data);
        $ivLength = openssl_cipher_iv_length('aes-256-cbc');
        $iv = substr($decodedData, 0, $ivLength);
        $encryptedData = substr($decodedData, $ivLength);

        return openssl_decrypt($encryptedData, 'AES-256-CBC', $encryptionKey, 0, $iv);
    }
 }