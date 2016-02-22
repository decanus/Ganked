<?php

/**
 * Copyright (c) Ganked 2015
 * All rights reserved.
 */

namespace Ganked\Frontend\Queries
{

    use Ganked\Skeleton\Gateways\LoLGateway;

    abstract class AbstractLeagueOfLegendsQuery
    {
        /**
         * @var LoLGateway
         */
        private $gateway;

        /**
         * @param LoLGateway $gateway
         */
        public function __construct(LoLGateway $gateway)
        {
            $this->gateway = $gateway;
        }

        /**
         * @return LoLGateway
         */
        public function getGateway()
        {
            return $this->gateway;
        }
    }
}
