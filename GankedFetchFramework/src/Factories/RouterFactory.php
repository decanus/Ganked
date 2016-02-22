<?php

/**
 * Copyright (c) Dean Eigenmann 2015
 * All rights reserved.
 */
 
namespace Ganked\Fetch\Factories
{
    class RouterFactory extends \Ganked\Skeleton\Factories\RouterFactory
    {
        /**
         * @return \Ganked\Fetch\Routers\DataFetchRouter
         */
        public function createDataFetchRouter()
        {
            return new \Ganked\Fetch\Routers\DataFetchRouter($this->getMasterFactory());
        }
    }
}
