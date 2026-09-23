<?php

use Illuminate\Http\Client\Request;
use Illuminate\Support\Facades\Http;
use SmartDato\SfExpress\BizMsgCrypt;
use SmartDato\SfExpress\Facades\SfExpress as SfExpressFacade;
use SmartDato\SfExpress\SfExpress;

const SF_TEST_AES_KEY = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQ';

function fakeSfExpress(array $decryptedResult): void
{
    $encryptedResult = (new BizMsgCrypt('token-1', SF_TEST_AES_KEY, 'app-key'))
        ->encrypt(json_encode($decryptedResult), 0, 'nonce')['encrypt'];

    Http::fake([
        '*/openapi/api/token*' => Http::response(['apiResultCode' => 0, 'apiResultData' => ['accessToken' => 'token-1']]),
        '*/openapi/api/dispatch' => Http::response(['apiResultCode' => 0, 'apiResultData' => $encryptedResult]),
    ]);
}

it('does not call the api when constructed', function () {
    Http::fake();

    new SfExpress(baseUrl: 'https://sf.test', appKey: 'app-key', appSecret: 'secret', encodingAesKey: SF_TEST_AES_KEY);

    Http::assertNothingSent();
});

it('authenticates lazily and decrypts the response', function () {
    fakeSfExpress(['msg' => 'success']);

    $sf = new SfExpress(baseUrl: 'https://sf.test', appKey: 'app-key', appSecret: 'secret', encodingAesKey: SF_TEST_AES_KEY);

    expect($sf->getTrackingStatus('{}'))->toBe(['msg' => 'success']);

    Http::assertSent(fn (Request $request): bool => str_starts_with($request->url(), 'https://sf.test/openapi/api/token')
        && $request['appKey'] === 'app-key'
        && $request['appSecret'] === 'secret');

    Http::assertSent(fn (Request $request): bool => $request->url() === 'https://sf.test/openapi/api/dispatch'
        && $request->header('appKey') === ['app-key']
        && $request->header('token') === ['token-1']
        && $request->header('msgType') === ['GTS_QUERY_TRACK']);
});

it('falls back to the config for every setting', function () {
    config()->set('sf-express-sdk.base_url', 'https://sf.test');
    config()->set('sf-express-sdk.app.key', 'app-key');
    config()->set('sf-express-sdk.app.secret', 'secret');
    config()->set('sf-express-sdk.app.encoding_aes_key', SF_TEST_AES_KEY);

    fakeSfExpress(['msg' => 'success']);

    expect(SfExpressFacade::getTrackingStatus('{}'))->toBe(['msg' => 'success']);
});
