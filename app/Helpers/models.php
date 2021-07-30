<?php

if (!function_exists('streams_model')) {
    /**
     * Returns streams model.
     *
     * @return \App\Models\Streams
     */
    function streams_model()
    {
        return app(\App\Models\Streams::class);
    }
}

if (!function_exists('followed_games_model')) {
    /**
     * Returns followed games model.
     *
     * @return \App\Models\FollowedGames
     */
    function followed_games_model()
    {
        return app(\App\Models\FollowedGames::class);
    }
}
