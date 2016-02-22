<?php

 /**
 * Copyright (c) Ganked 2015
 * All rights reserved.
 */
 
namespace Ganked\API\Factories
{
    /**
     * @covers Ganked\API\Factories\ServiceFactory
     * @uses Ganked\API\Factories\BackendFactory
     * @uses \Ganked\API\Services\AbstractDatabaseService
     */
    class ServiceFactoryTest extends GenericFactoryTestHelper
    {

        /**
         * @return array
         */
        public function provideInstanceNames()
        {
            return [
                ['createUserService', \Ganked\API\Services\UserService::class],
                ['createPostsService', \Ganked\API\Services\PostsService::class],
                ['createFavouriteService', \Ganked\API\Services\FavouritesService::class],
            ];
        }
    }
}
