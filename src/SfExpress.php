<?php

namespace SmartDato\SfExpress;

use Exception;
use Illuminate\Http\Client\ConnectionException;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;
use JsonException;
use Random\RandomException;
use SmartDato\SfExpress\Exceptions\SfExpressGenericException;

class SfExpress
{
    private ?string $token = null;

    private ?BizMsgCrypt $bizCrypt = null;

    public function __construct(
        protected ?string $baseUrl = null,
        protected ?string $appKey = null,
        protected ?string $appSecret = null,
        protected ?string $encodingAesKey = null,
    ) {
        $this->baseUrl ??= (string) config('sf-express-sdk.base_url');
        $this->appKey ??= (string) config('sf-express-sdk.app.key');
        $this->appSecret ??= (string) config('sf-express-sdk.app.secret');
        $this->encodingAesKey ??= (string) config('sf-express-sdk.app.encoding_aes_key');
    }

    /**
     * @throws ConnectionException
     * @throws SfExpressGenericException
     */
    public function accessToken(?string $appKey = null, ?string $appSecret = null)
    {
        $response = Http::baseUrl($this->baseUrl)
            ->get('/openapi/api/token', [
                'appKey' => $appKey ?? $this->appKey,
                'appSecret' => $appSecret ?? $this->appSecret,
            ]);

        if ($response->failed()) {
            throw new SfExpressGenericException;
        }

        $data = $response->json();
        if (! array_key_exists('apiResultCode', $data)) {
            throw new SfExpressGenericException;
        }

        if ($data['apiResultCode'] !== 0) {
            $message = $data['apiResultCode'].' - '.$data['apiErrorMsg'];
            throw new SfExpressGenericException($message);
        }

        return $response->json();
    }

    /**
     * Fetches the access token on first use, so constructing the client never hits the network.
     *
     * @throws ConnectionException
     * @throws SfExpressGenericException
     * @throws Exception
     */
    private function bizCrypt(): BizMsgCrypt
    {
        if ($this->bizCrypt !== null) {
            return $this->bizCrypt;
        }

        $this->token = $this->accessToken()['apiResultData']['accessToken'];

        return $this->bizCrypt = new BizMsgCrypt(
            $this->token,
            $this->encodingAesKey,
            $this->appKey
        );
    }

    /**
     * @throws Exception
     */
    public function createShipment(string $data): array
    {
        $response = $this->sendRequest($data, 'IUOP_CREATE_ORDER');

        $message = $this->bizCrypt()->decrypt($response['apiResultData']);

        return json_decode($message, true, 512, JSON_THROW_ON_ERROR);
    }

    /**
     * @throws RandomException
     * @throws ConnectionException
     * @throws SfExpressGenericException
     */
    private function sendRequest($data, $messageType): array
    {
        $timestamp = (int) floor(microtime(true) * 1000);
        $nonce = Str::uuid()->toString();

        $encryptedMsg = $this->bizCrypt()->encrypt(
            $data,
            $timestamp,
            $nonce
        );

        $response = Http::baseUrl($this->baseUrl)
            ->withHeaders([
                'appKey' => $this->appKey,
                'token' => $this->token,
                'timestamp' => $timestamp,
                'nonce' => $nonce,
                'signature' => $encryptedMsg['signature'],
                'msgType' => $messageType,
                'lang' => 'en',
                'Content-Type' => 'application/json',
            ])
            ->withBody($encryptedMsg['encrypt'])
            ->post('/openapi/api/dispatch');

        if ($response->failed()) {
            throw new SfExpressGenericException;
        }

        $data = $response->json();
        if (! array_key_exists('apiResultCode', $data)) {
            throw new SfExpressGenericException;
        }

        if ($data['apiResultCode'] !== 0) {
            $message = $data['apiResultCode'].' - '.$data['apiErrorMsg'];
            throw new SfExpressGenericException($message);
        }

        return $response->json();
    }

    /**
     * @throws ConnectionException
     * @throws JsonException
     * @throws RandomException
     * @throws SfExpressGenericException
     */
    public function getTrackingStatus(string $data): array
    {
        $response = $this->sendRequest($data, 'GTS_QUERY_TRACK');
        $message = $this->bizCrypt()->decrypt($response['apiResultData']);

        return json_decode($message, true, 512, JSON_THROW_ON_ERROR);
    }

    /**
     * @throws RandomException
     * @throws SfExpressGenericException
     * @throws ConnectionException
     * @throws JsonException
     */
    public function getShipmentDetails(string $data): array
    {
        $response = $this->sendRequest($data, 'IUOP_QUERY_ORDER');
        $message = $this->bizCrypt()->decrypt($response['apiResultData']);

        return json_decode($message, true, 512, JSON_THROW_ON_ERROR);
    }
}
