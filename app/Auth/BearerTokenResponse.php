<?php

namespace App\Auth;

use App\User;
use League\OAuth2\Server\Entities\AccessTokenEntityInterface;
use \League\OAuth2\Server\ResponseTypes\BearerTokenResponse as BearerResponse;

class BearerTokenResponse extends BearerResponse
{
    protected function getExtraParams(AccessTokenEntityInterface $accessToken)
    {
        if (is_null($this->accessToken->getUserIdentifier())) return [];

        $user = User::find($this->accessToken->getUserIdentifier());
        $user->last_login = date('Y-m-d H:i:s');
        $user->save();

        return [
            'user' => $user->toArray()
        ];
    }
}
