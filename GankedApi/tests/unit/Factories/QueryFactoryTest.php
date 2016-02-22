<?php

 /**
 * Copyright (c) Ganked 2015
 * All rights reserved.
 */
 
namespace Ganked\API\Factories
{
    /**
     * @covers Ganked\API\Factories\QueryFactory
     * @uses Ganked\API\Factories\BackendFactory
     * @uses Ganked\API\Factories\ServiceFactory
     * @uses \Ganked\API\Queries\GetUserFromDatabaseQuery
     * @uses \Ganked\API\Services\AbstractDatabaseService
     * @uses \Ganked\API\Queries\GetPostsForUserQuery
     * @uses \Ganked\API\Queries\GetPostByIdQuery
     * @uses \Ganked\API\Queries\FetchPostsByIdsQuery
     * @uses \Ganked\API\Queries\HasUserByIdQuery
     * @uses \Ganked\API\Queries\FetchUserIdForAccessTokenQuery
     * @uses \Ganked\API\Queries\HasPostByIdQuery
     * @uses \Ganked\API\Queries\FetchAccountWithEmailQuery
     * @uses \Ganked\API\Queries\FetchAccountWithUsernameQuery
     * @uses \Ganked\API\Queries\FetchUserByIdQuery
     * @uses \Ganked\API\Queries\FetchFavouriteSummonersForUserQuery
     * @uses \Ganked\API\Queries\IsFavouritingSummonerQuery
     * @uses \Ganked\API\Queries\FetchSummonersFromRedisQuery
     */
    class QueryFactoryTest extends GenericFactoryTestHelper
    {

        /**
         * @return array
         */
        public function provideInstanceNames()
        {
            return [
                ['createGetUserFromDatabaseQuery', \Ganked\API\Queries\GetUserFromDatabaseQuery::class],
                ['createGetPostsForUserQuery', \Ganked\API\Queries\GetPostsForUserQuery::class],
                ['createGetPostByIdQuery', \Ganked\API\Queries\GetPostByIdQuery::class],
                ['createFetchPostsByIdsQuery', \Ganked\API\Queries\FetchPostsByIdsQuery::class],
                ['createHasPostByIdQuery', \Ganked\API\Queries\HasPostByIdQuery::class],
                ['createFetchUserIdForAccessTokenQuery', \Ganked\API\Queries\FetchUserIdForAccessTokenQuery::class],
                ['createHasUserByIdQuery', \Ganked\API\Queries\HasUserByIdQuery::class],
                ['createFetchUserByIdQuery', \Ganked\API\Queries\FetchUserByIdQuery::class],
                ['createFetchAccountWithUsernameQuery', \Ganked\API\Queries\FetchAccountWithUsernameQuery::class],
                ['createFetchAccountWithEmailQuery', \Ganked\API\Queries\FetchAccountWithEmailQuery::class],
                ['createFetchFavouriteSummonersForUserQuery', \Ganked\API\Queries\FetchFavouriteSummonersForUserQuery::class],
                ['createIsFavouritingSummonerQuery', \Ganked\API\Queries\IsFavouritingSummonerQuery::class],
                ['createFetchSummonersFromRedisQuery', \Ganked\API\Queries\FetchSummonersFromRedisQuery::class],
            ];
        }
    }
}
