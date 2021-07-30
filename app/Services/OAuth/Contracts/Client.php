<?php

namespace App\Services\OAuth\Contracts;

interface Client
{
    /**
     * Gets OAuth token.
     *
     * @return array
     */
    public function getToken();
}
