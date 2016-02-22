<?php

/**
 * Copyright (c) Ganked 2015
 * All rights reserved.
 */
 
namespace Ganked\Skeleton\Queries
{

    use Ganked\Library\Gateways\GankedApiGateway;

    class FetchAccountQuery
    {
        /**
         * @var GankedApiGateway
         */
        private $gateway;

        /**
         * @param GankedApiGateway $gateway
         */
        public function __construct(GankedApiGateway $gateway)
        {
            $this->gateway = $gateway;
        }

        /**
         * @param string $account
         *
         * @return array
         */
        public function execute($account)
        {
            return $this->gateway->getAccount((string) $account)->getDecodedJsonResponse();
        }
    }
}
