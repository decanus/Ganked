<?php

/**
 * Copyright (c) Ganked 2015
 * All rights reserved.
 */
 
namespace Ganked\Skeleton\Queries
{

    use Ganked\Skeleton\Gateways\LoLGateway;

    class FetchMatchForRegionQuery
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
         * @param string $region
         * @param int    $id
         * @return \Ganked\Skeleton\Backends\Wrappers\CurlResponse
         */
        public function execute($region, $id)
        {
            return $this->gateway->getMatchForRegion($region, $id);
        }
    }
}
