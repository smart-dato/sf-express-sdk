<?php

namespace SmartDato\SfExpress;

use Random\RandomException;
use SmartDato\SfExpress\Exceptions\InvalidKeyLengthException;

class BizMsgCrypt
{
    /**
     * @throws InvalidKeyLengthException
     */
    public function __construct(
        protected string $token,
        protected string $encodingAesKey,
        protected string $appKey
    ) {
        if (strlen($encodingAesKey) !== 43) {
            throw new InvalidKeyLengthException('Invalid AES key length');
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
