<?php

namespace App\Services\OAuth\Twitch;

use App\Services\OAuth\Contracts\Client as IClient;
use Illuminate\Support\Facades\Http;

class Client implements IClient
{
    /**
     * Service auth url.
     *
     * @var string
     */
    protected $url = "https://id.twitch.tv/oauth2/";

    /**
     * Gets OAuth token.
     *
     * @return array
     */
    public function getToken()
    {
        $params = [
            'client_id' => env('TWITCH_CLIENT_ID'),
            'client_secret' => env('TWITCH_CLIENT_SECRET'),
            'grant_type' => 'client_credentials',
        ];

        $result = Http::post($this->url . 'token', $params);

        return $result ? json_decode($result) : [];
    }
}
