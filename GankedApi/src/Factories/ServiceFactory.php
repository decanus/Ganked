<?php

 /**
 * Copyright (c) Ganked 2015
 * All rights reserved.
 */
 
namespace Ganked\API\Factories
{
    use Ganked\Skeleton\Factories\AbstractFactory;

    class ServiceFactory extends AbstractFactory
    {
        /**
         * @return \Ganked\API\Services\UserService
         */
        public function createUserService()
        {
            return new \Ganked\API\Services\UserService($this->getMasterFactory()->createMongoDatabaseBackend());
        }

        /**
         * @return \Ganked\API\Services\PostsService
         */
        public function createPostsService()
        {
            return new \Ganked\API\Services\PostsService($this->getMasterFactory()->createMongoDatabaseBackend());
        }

        /**
         * @return \Ganked\API\Services\FavouritesService
         */
        public function createFavouriteService()
        {
            return new \Ganked\API\Services\FavouritesService($this->getMasterFactory()->createMongoDatabaseBackend());
        }
    }
}
