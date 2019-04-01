<?php


defined('BASEPATH') OR exit('No direct script access allowed');


class aescrypto {

    /**
     * Permite cifrar una cadena a partir de un llave proporcionada
     * @param strToEncrypt
     * @param key
     * @return String con la cadena encriptada
     */

    public function oka()
    {
        return 'oka';
    }

    public function encriptar($plaintext, $key128)
    {
        $iv = openssl_random_pseudo_bytes(openssl_cipher_iv_length('aes-128-cbc'));
        $cipherText = openssl_encrypt($plaintext, 'AES-128-CBC', hex2bin($key128), 1, $iv);
        return base64_encode($iv . $cipherText);
    }


    /**
     * Permite descifrar una cadena a partir de un llave proporcionada
     * @param strToDecrypt
     * @param key
     * @return String con la cadena descifrada
     */

    public function desencriptar($encodedInitialData, $key128)
    {
        $encodedInitialData = base64_decode($encodedInitialData);
        $iv = substr($encodedInitialData, 0, 16);
        $encodedInitialData = substr($encodedInitialData, 16);
        $decrypted = openssl_decrypt($encodedInitialData, 'AES-128-CBC', hex2bin($key128), 1, $iv);
        return $decrypted;
    }

}