<?php

namespace SmartDato\SfExpress;

use Exception;
use Random\RandomException;

class BizMsgCrypt
{
    /**
     * @throws Exception
     */
    public function __construct(
        protected string $token,
        protected string $encodingAesKey,
        protected string $appKey
    ) {
        if (strlen($encodingAesKey) != 43) {
            throw new Exception('Invalid AES key length');
        }
    }

    /**
     * @throws RandomException
     */
    public function encrypt($replyMsg, $timestamp, $nonce): array
    {
        $aesCrypt = new AesCrypt($this->encodingAesKey);
        $encryptedMsg = $aesCrypt->encrypt($replyMsg, $this->appKey);
        $signature = $this->signature($this->token, $timestamp, $nonce, $encryptedMsg);

        return [
            'encrypt' => $encryptedMsg,
            'signature' => $signature,
            'timestamp' => $timestamp,
            'nonce' => $nonce,
        ];
    }

    public function signature($token, $timestamp, $nonce, $encryptedMsg): string
    {
        $str = [$token, $timestamp, $nonce, $encryptedMsg];
        sort($str, SORT_STRING);
        $s = implode('', $str);

        return hash('sha256', $s);
    }

    public function decrypt($encrypted): ?string
    {
        $aesCrypt = new AesCrypt($this->encodingAesKey);

        return $aesCrypt->decrypt($encrypted, $this->appKey);
    }
}
