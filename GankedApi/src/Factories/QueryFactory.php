<?php

 /**
 * Copyright (c) Ganked 2015
 * All rights reserved.
 */
 
namespace Ganked\API\Factories
{
    use Ganked\Skeleton\Factories\AbstractFactory;

    class QueryFactory extends AbstractFactory
    {
        /**
         * @return \Ganked\API\Queries\GetUserFromDatabaseQuery
         */
        public function createGetUserFromDatabaseQuery()
        {
            return new \Ganked\API\Queries\GetUserFromDatabaseQuery(
                $this->getMasterFactory()->createUserService()
            );
        }

        /**
         * @return \Ganked\API\Queries\GetPostByIdQuery
         */
        public function createGetPostByIdQuery()
        {
            return new \Ganked\API\Queries\GetPostByIdQuery(
                $this->getMasterFactory()->createPostsService()
            );
        }

        /**
         * @return \Ganked\API\Queries\GetPostsForUserQuery
         */
        public function createGetPostsForUserQuery()
        {
            return new \Ganked\API\Queries\GetPostsForUserQuery(
                $this->getMasterFactory()->createPostsService()
            );
        }

        /**
         * @return \Ganked\API\Queries\FetchPostsByIdsQuery
         */
        public function createFetchPostsByIdsQuery()
        {
            return new \Ganked\API\Queries\FetchPostsByIdsQuery(
                $this->getMasterFactory()->createPostsService()
            );
        }

        /**
         * @return \Ganked\API\Queries\HasPostByIdQuery
         */
        public function createHasPostByIdQuery()
        {
            return new \Ganked\API\Queries\HasPostByIdQuery(
                $this->getMasterFactory()->createPostsService()
            );
        }

        /**
         * @return \Ganked\API\Queries\FetchUserIdForAccessTokenQuery
         */
        public function createFetchUserIdForAccessTokenQuery()
        {
            return new \Ganked\API\Queries\FetchUserIdForAccessTokenQuery(
                $this->getMasterFactory()->createRedisBackend()
            );
        }

        /**
         * @return \Ganked\API\Queries\FetchUserByIdQuery
         */
        public function createFetchUserByIdQuery()
        {
            return new \Ganked\API\Queries\FetchUserByIdQuery(
                $this->getMasterFactory()->createUserService()
            );
        }

        /**
         * @return \Ganked\API\Queries\FetchUserBySteamIdQuery
         */
        public function createFetchUserBySteamIdQuery()
        {
            return new \Ganked\API\Queries\FetchUserBySteamIdQuery(
                $this->getMasterFactory()->createUserService()
            );
        }

        /**
         * @return \Ganked\API\Queries\HasUserByIdQuery
         */
        public function createHasUserByIdQuery()
        {
            return new \Ganked\API\Queries\HasUserByIdQuery(
                $this->getMasterFactory()->createUserService()
            );
        }

        /**
         * @return \Ganked\API\Queries\FetchAccountWithUsernameQuery
         */
        public function createFetchAccountWithUsernameQuery()
        {
            return new \Ganked\API\Queries\FetchAccountWithUsernameQuery(
                $this->getMasterFactory()->createUserService()
            );
        }

        /**
         * @return \Ganked\API\Queries\FetchAccountWithEmailQuery
         */
        public function createFetchAccountWithEmailQuery()
        {
            return new \Ganked\API\Queries\FetchAccountWithEmailQuery(
                $this->getMasterFactory()->createUserService()
            );
        }

        /**
         * @return \Ganked\API\Queries\FetchFavouriteSummonersForUserQuery
         */
        public function createFetchFavouriteSummonersForUserQuery()
        {
            return new \Ganked\API\Queries\FetchFavouriteSummonersForUserQuery(
                $this->getMasterFactory()->createFavouriteService()
            );
        }

        /**
         * @return \Ganked\API\Queries\IsFavouritingSummonerQuery
         */
        public function createIsFavouritingSummonerQuery()
        {
            return new \Ganked\API\Queries\IsFavouritingSummonerQuery(
                $this->getMasterFactory()->createFavouriteService()
            );
        }

        /**
         * @return \Ganked\API\Queries\FetchSummonersFromRedisQuery
         */
        public function createFetchSummonersFromRedisQuery()
        {
            return new \Ganked\API\Queries\FetchSummonersFromRedisQuery(
                $this->getMasterFactory()->createDataPoolReader()
            );
        }
    }
}
