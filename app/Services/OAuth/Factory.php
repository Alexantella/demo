<?php

namespace App\Services\OAuth;

use Illuminate\Support\Str;

class Factory
{
    /**
     * Returns instance of service client.
     *
     * @param  string  $serviceName
     * @return \App\Services\OAuth\Contracts\Client
     */
    public function build(string $serviceName)
    {
        return app(
            implode(
                '\\',
                [
                    __NAMESPACE__,
                    Str::studly($serviceName),
                    "Client",
                ]
            )
        );
    }
}
