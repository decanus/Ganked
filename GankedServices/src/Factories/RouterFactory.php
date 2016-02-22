<?php
 /**
 * Copyright (c) Dean Eigenmann 2015
 * All rights reserved.
 */

namespace Ganked\Services\Factories
{
    class RouterFactory extends \Ganked\Skeleton\Factories\RouterFactory
    {
        /**
         * @return \Ganked\Services\Routers\ServiceRouter
         */
        public function createServiceRouter()
        {
            return new \Ganked\Services\Routers\ServiceRouter(
                $this->getMasterFactory()
            );
        }
    }
}