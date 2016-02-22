<?php

/**
 * Copyright (c) Dean Eigenmann 2015
 * All rights reserved.
 */
 
namespace Ganked\Skeleton\Gateways
{

    use Ganked\Skeleton\Backends\Wrappers\CurlResponse;

    /**
     * @method CurlResponse getTopStreamsForGame(string $game, int $limit)
     */
    class TwitchGateway extends AbstractGateway
    {
    }
}
