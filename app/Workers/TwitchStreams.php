<?php

namespace App\Workers;

class TwitchStreams
{
    /**
     * Run worker
     *
     */
    public function run()
    {
        $games = followed_games_model()->all();

        $factory = app(\App\Services\Executors\Factory::class);

        /** @var  \App\Services\Executors\Twitch\Api $client */
        $client = $factory->build('twitch');

        foreach ($games as $game) {
            $data = $client->getStreams($game->game_id);

            if ($data) {
                foreach ($data as $stream) {
                    $params = [
                        'stream_id' => $stream->id,
                        'channel_id' => $stream->user_id,
                        'game_id' => $stream->game_id,
                        'game_name' => $stream->game_name,
                        'viewers' => $stream->viewer_count,
                        'service_name' => 'twitch',
                    ];

                    streams_model()->newQuery()->firstOrCreate($params);
                }
            }
        }
    }
}
