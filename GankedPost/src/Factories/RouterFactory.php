<?php

/**
 * Copyright (c) Dean Eigenmann 2015
 * All rights reserved.
 */
 
namespace Ganked\Post\Factories
{
    class RouterFactory extends \Ganked\Skeleton\Factories\RouterFactory
    {
        /**
         * @return \Ganked\Post\Routers\PostRequestRouter
         */
        public function createPostRequestRouter()
        {
            return new \Ganked\Post\Routers\PostRequestRouter($this->getMasterFactory());
        }
    }
}
