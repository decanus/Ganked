<?php

 /**
 * Copyright (c) Ganked 2015
 * All rights reserved.
 */
 
namespace Ganked\Frontend\Factories
{
    class GatewayFactory extends \Ganked\Skeleton\Factories\GatewayFactory
    {
        /**
         * @return \Ganked\Frontend\Gateways\Social\ProfileGateway
         */
        public function createProfileGateway()
        {
            return new \Ganked\Frontend\Gateways\Social\ProfileGateway(
                $this->createGetServiceHandler(),
                '/userProfile',
                'token'
            );
        }
    }
}
