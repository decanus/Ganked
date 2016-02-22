<?php

/**
 * Copyright (c) Ganked 2015
 * All rights reserved.
 */

namespace Ganked\Skeleton\Queries
{

    use Ganked\Library\Gateways\GankedApiGateway;
    use Ganked\Library\ValueObjects\UserId;

    class FetchUserByIdQuery
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
         * @param UserId $id
         *
         * @return \Ganked\Library\Curl\Response
         */
        public function execute(UserId $id)
        {
            return $this->gateway->getUserWithUserId($id);
        }

    }
}
