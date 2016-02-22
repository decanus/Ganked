<?php

/**
 * Copyright (c) Ganked 2015
 * All rights reserved.
 */

namespace Ganked\Skeleton\Gateways
{

    use Ganked\Skeleton\Backends\Wrappers\CurlResponse;

    /**
     * @method CurlResponse getPlayerBans(array $steamIds = [])
     * @method CurlResponse resolveVanityUrl($steamCustomId)
     */
    class SteamGateway extends AbstractGateway
    {

    }
}
