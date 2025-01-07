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
    private string $token;

    private BizMsgCrypt $bizCrypt;

    private int $timestamp;

    private string $nonce;

    /**
     * @throws SfExpressGenericException
     * @throws ConnectionException
     * @throws Exception
     */
    public function __construct(
        protected ?string $baseUrl = null,
        protected ?string $appKey = null,
        protected ?string $appSecret = null,
        protected ?string $encodingAesKey = null,

    ) {
        $response = $this->accessToken(
            $appKey,
            $appSecret
        );

        $this->token = $response['apiResultData']['accessToken'];
        $this->initCommonData();
    }

    /**
     * @throws ConnectionException
     * @throws SfExpressGenericException
     */
    public function accessToken(?string $appKey = null, ?string $appSecret = null)
    {
        $response = Http::baseUrl($this->baseUrl)
            ->get('/openapi/api/token', [
                'appKey' => $appKey ?? config('sf-express-sdk.app.key'),
                'appSecret' => $appSecret ?? config('sf-express-sdk.app.secret'),
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
     * @throws Exception
     */
    private function initCommonData(): void
    {
        $this->bizCrypt = new BizMsgCrypt(
            $this->token,
            $this->encodingAesKey,
            $this->appKey
        );

        $this->timestamp = (int) floor(microtime(true) * 1000);
        $this->nonce = Str::uuid()->toString();
    }

    /**
     * @throws Exception
     */
    public function createShipment(string $data): array
    {
        $response = $this->sendRequest($data, 'IUOP_CREATE_ORDER');

        $message = $this->bizCrypt->decrypt($response['apiResultData']);

        return json_decode($message, true, 512, JSON_THROW_ON_ERROR);
    }

    /**
     * @throws RandomException
     * @throws ConnectionException
     * @throws SfExpressGenericException
     */
    private function sendRequest($data, $messageType): array
    {
        $encryptedMsg = $this->bizCrypt->encrypt(
            $data,
            $this->timestamp,
            $this->nonce
        );

        $response = Http::baseUrl($this->baseUrl)
            ->withHeaders([
                'appKey' => $this->appKey,
                'token' => $this->token,
                'timestamp' => $this->timestamp,
                'nonce' => $this->nonce,
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
        $message = $this->bizCrypt->decrypt($response['apiResultData']);

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
        $message = $this->bizCrypt->decrypt($response['apiResultData']);

        return json_decode($message, true, 512, JSON_THROW_ON_ERROR);
    }
}
