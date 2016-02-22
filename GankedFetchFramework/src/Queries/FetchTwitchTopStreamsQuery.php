<?php

/**
 * Copyright (c) Dean Eigenmann 2015
 * All rights reserved.
 */
 
namespace Ganked\Fetch\Queries
{

    use Ganked\Skeleton\Gateways\TwitchGateway;

    class FetchTwitchTopStreamsQuery
    {
        /**
         * @var TwitchGateway
         */
        private $gateway;

        /**
         * @param TwitchGateway $gateway
         */
        public function __construct(TwitchGateway $gateway)
        {
            $this->gateway = $gateway;
        }

        /**
         * @param string $game
         * @param int    $limit
         * @return \Ganked\Skeleton\Backends\Wrappers\CurlResponse
         */
        public function execute($game, $limit)
        {
            return $this->gateway->getTopStreamsForGame($game, $limit);
        }
    }
}
