<?php

namespace App\Services\Executors;

use Illuminate\Support\Str;

class Factory
{
    /**
     * Returns instance of service client.
     *
     * @param  string  $serviceName
     * @return \App\Services\Executors\Contracts\Api
     */
    public function build(string $serviceName)
    {
        return app(
            implode(
                '\\',
                [
                    __NAMESPACE__,
                    Str::studly($serviceName),
                    "Api",
                ]
            )
        );
    }
}
