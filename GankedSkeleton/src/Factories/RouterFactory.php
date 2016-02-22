<?php
 /**
 * Copyright (c) Dean Eigenmann 2015
 * All rights reserved.
 */

namespace Ganked\Skeleton\Factories
{
    class RouterFactory extends AbstractFactory
    {
        /**
         * @return \Ganked\Skeleton\Routers\JsonErrorRouter
         */
        public function createJsonErrorRouter()
        {
            return new \Ganked\Skeleton\Routers\JsonErrorRouter($this->getMasterFactory());
        }
    }
}