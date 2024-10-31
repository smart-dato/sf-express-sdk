<?php

namespace SmartDato\SfExpress;

use Random\RandomException;

class AesCrypt
{
    public function __construct(
        protected string $key
    ) {
        $this->key = base64_decode($key.'=');
    }

    /**
     * @throws RandomException
     */
    public function encrypt(string $text, string $appKey): string
    {
        $random = $this->getRandomStr();
        $packed = $this->pack(strlen($text));
        $data = $random.$packed.$text.$appKey;

        $iv = substr($this->key, 0, 16);
        $decoded = pkcs7_encode($data);
        $encrypted = openssl_encrypt(
            $decoded,
            'AES-256-CBC',
            $this->key,
            OPENSSL_NO_PADDING,
            $iv
        );

        return base64_encode($encrypted);
    }

    /**
     * @throws RandomException
     */
    private function getRandomStr(): string
    {
        $chars = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789';
        $str = '';
        for ($i = 0; $i < 16; $i++) {
            $str .= $chars[random_int(0, strlen($chars) - 1)];
        }

        return $str;
    }

    private function pack(int $length): string
    {
        return pack('N', $length);
    }

    public function decrypt(string $encrypted, $appKey): ?string
    {
        $iv = substr($this->key, 0, 16);
        $decoded = base64_decode($encrypted);
        $decrypted = openssl_decrypt(
            $decoded,
            'AES-256-CBC',
            $this->key,
            OPENSSL_NO_PADDING,
            $iv
        );

        $data = pkcs7_decode($decrypted);

        // Extract message length and actual content
        $content = substr($data, 16); // Remove random string
        $msgLength = unpack('N', substr($content, 0, 4))[1];
        $message = substr($content, 4, $msgLength);
        $appIdInMessage = substr($content, $msgLength + 4);

        if ($appKey === $appIdInMessage) {
            return $message;
        }

        return null;
    }
}
