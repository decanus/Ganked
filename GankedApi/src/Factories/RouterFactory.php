<?php

 /**
 * Copyright (c) Ganked 2015
 * All rights reserved.
 */
 
namespace Ganked\API\Factories
{
    use Ganked\Skeleton\Factories\AbstractFactory;

    class RouterFactory extends AbstractFactory
    {
        /**
         * @return \Ganked\API\Routers\GetRequestRouter
         */
        public function createGetRequestRouter()
        {
            return new \Ganked\API\Routers\GetRequestRouter($this->getMasterFactory());
        }

        /**
         * @return \Ganked\API\Routers\PostRequestRouter
         */
        public function createPostRequestRouter()
        {
            return new \Ganked\API\Routers\PostRequestRouter($this->getMasterFactory());
        }

        /**
         * @return \Ganked\API\Routers\DeleteRequestRouter
         */
        public function createDeleteRequestRouter()
        {
            return new \Ganked\API\Routers\DeleteRequestRouter($this->getMasterFactory());
        }

        /**
         * @return \Ganked\API\Routers\PatchRequestRouter
         */
        public function createPatchRequestRouter()
        {
            return new \Ganked\API\Routers\PatchRequestRouter($this->getMasterFactory());
        }
    }
}
