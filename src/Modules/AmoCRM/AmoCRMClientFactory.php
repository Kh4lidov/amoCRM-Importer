<?php

namespace Modules\AmoCRM;

use AmoCRM\Client\AmoCRMApiClient;
use League\OAuth2\Client\Token\AccessToken;
use League\OAuth2\Client\Token\AccessTokenInterface;

class AmoCRMClientFactory
{
    public static function getClient(): AmoCRMApiClient {
        $apiClient = new AmoCRMApiClient(config('amocrm.client_id'), config('amocrm.secret'),  config('amocrm.uri'));

        $accessToken = new AccessToken(json_decode(file_get_contents(config('amocrm.token_path')), true));

        $apiClient->setAccessToken($accessToken)
            ->setAccountBaseDomain($accessToken->getValues()['baseDomain'])
            ->onAccessTokenRefresh(
                function (AccessTokenInterface $accessToken, string $baseDomain) {
                    file_put_contents(
                        config('amocrm.token_path'),
                        json_encode([
                            'access_token' => $accessToken->getToken(),
                            'refresh_token' => $accessToken->getRefreshToken(),
                            'expires' => $accessToken->getExpires(),
                            'baseDomain' => $baseDomain,
                        ])
                    );
                }
            );

        return $apiClient;
    }
}
