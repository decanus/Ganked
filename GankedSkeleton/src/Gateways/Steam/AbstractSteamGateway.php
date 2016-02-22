<?php
 /**
 * Copyright (c) Dean Eigenmann 2015
 * All rights reserved.
 */

namespace Ganked\Skeleton\Gateways
{

    use Ganked\Skeleton\Backends\Wrappers\CurlResponse;

    /**
     * @method CurlResponse getSteamUserInfoById(string $id)
     * @method CurlResponse getSteamUserById(string $id)
     * @method CurlResponse getUserStatsForGame(string $steam64)
     * @method CurlResponse getNewsForApp()
     */
    abstract class AbstractSteamGateway extends AbstractGateway
    {
    }
}