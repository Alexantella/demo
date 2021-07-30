<?php

namespace App\Services\Executors\Twitch;

use App\Services\OAuth\Factory;
use Illuminate\Http\Client\PendingRequest;
use Illuminate\Support\Facades\Http;

class Api
{
    /**
     * Api url.
     *
     * @var string
     */
    protected $url = 'https://api.twitch.tv';

    /**
     * Max count of elements on the page.
     *
     * @var integer
     */
    protected $maxCount = 100;

    /**
     * Client token.
     *
     * @var PendingRequest
     */
    protected $token;

    /**
     * Service auth url.
     *
     * @var PendingRequest
     */
    protected $guzzle;

    public function __construct()
    {
        $factory = new Factory();

        /** @var  \App\Services\OAuth\Contracts\Client $client */
        $client = $factory->build('twitch');

        $this->token = $client->getToken();

        $this->guzzle = Http::withToken($this->token->access_token)
                            ->withHeaders(['Client-Id' => env('TWITCH_CLIENT_ID')]);
    }

    /**
     * Gets streams from api
     *
     * @param  integer  $game
     * @return array
     */
    public function getStreams(int $game)
    {
        $result = [];
        $stop = false;
        $cursor = '';
        $params = [
            'first' => $this->maxCount,
            'game_id' => $game,
        ];

        do {
            if ($cursor) {
                $params['after'] = $cursor;
            }

            $query = $this->guzzle->get($this->url . '/helix/streams?' . http_build_query($params));

            //Should be some errors handler here
            if ($query->status() != 200) {
                continue;
            }

            if ($query) {
                $decoded = json_decode($query);

                if (count($decoded->data) < $this->maxCount || !isset($decoded->data)) {
                    $stop = true;
                }

                $result = array_merge($result, (array) $decoded->data);

                if (isset($decoded->pagination->cursor)) {
                    $cursor = $decoded->pagination->cursor;
                } else {
                    $stop = true;
                }
            }
        } while (!$stop);

        return $result;
    }
}
