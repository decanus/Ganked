<?php

 /**
 * Copyright (c) Ganked 2015
 * All rights reserved.
 */
 
namespace Ganked\API\Factories
{
    use Ganked\Skeleton\Factories\AbstractFactory;

    class HandlerFactory extends AbstractFactory
    {
        /**
         * @return \Ganked\API\Handlers\PreHandler
         */
        public function createPreHandler()
        {
            return new \Ganked\API\Handlers\PreHandler(
                $this->getMasterFactory()->createTokenReader()
            );
        }

        /**
         * @return \Ganked\API\Handlers\Get\Users\Posts\QueryHandler
         */
        public function createGetUserPostsQueryHandler()
        {
            return new \Ganked\API\Handlers\Get\Users\Posts\QueryHandler(
                $this->getMasterFactory()->createGetPostsForUserQuery()
            );
        }

        /**
         * @return \Ganked\API\Handlers\ResponseHandler
         */
        public function createResponseHandler()
        {
            return new \Ganked\API\Handlers\ResponseHandler;
        }

        /**
         * @return \Ganked\API\Handlers\Get\Posts\QueryHandler
         */
        public function createGetPostQueryHandler()
        {
            return new \Ganked\API\Handlers\Get\Posts\QueryHandler(
                $this->getMasterFactory()->createGetPostByIdQuery()
            );
        }

        /**
         * @return \Ganked\API\Handlers\Get\Users\QueryHandler
         */
        public function createGetUserQueryHandler()
        {
            return new \Ganked\API\Handlers\Get\Users\QueryHandler(
                $this->getMasterFactory()->createGetUserFromDatabaseQuery(),
                $this->getMasterFactory()->createFetchUserByIdQuery(),
                $this->getMasterFactory()->createFetchUserBySteamIdQuery()
            );
        }

        /**
         * @return \Ganked\API\Handlers\CommandHandler
         */
        public function createCommandHandler()
        {
            return new \Ganked\API\Handlers\CommandHandler;
        }

        /**
         * @return \Ganked\API\Handlers\Post\Posts\Likes\QueryHandler
         */
        public function createLikePostQueryHandler()
        {
            return new \Ganked\API\Handlers\Post\Posts\Likes\QueryHandler(
                $this->getMasterFactory()->createHasPostByIdQuery(),
                $this->getMasterFactory()->createFetchUserIdForAccessTokenQuery()
            );
        }

        /**
         * @return \Ganked\API\Handlers\Post\Posts\Likes\CommandHandler
         */
        public function createLikePostCommandHandler()
        {
            return new \Ganked\API\Handlers\Post\Posts\Likes\CommandHandler(
                $this->getMasterFactory()->createLikePostCommand()
            );
        }

        /**
         * @return \Ganked\API\Handlers\Post\LeagueOfLegends\SummonerFavourite\CommandHandler
         */
        public function createFavouriteSummonerCommandHandler()
        {
            return new \Ganked\API\Handlers\Post\LeagueOfLegends\SummonerFavourite\CommandHandler(
                $this->getMasterFactory()->createFavouriteSummonerCommand()
            );
        }

        /**
         * @return \Ganked\API\Handlers\Delete\LeagueOfLegends\SummonerFavourite\CommandHandler
         */
        public function createUnfavouriteSummonerCommandHandler()
        {
            return new \Ganked\API\Handlers\Delete\LeagueOfLegends\SummonerFavourite\CommandHandler(
                $this->getMasterFactory()->createUnfavouriteSummonerCommand()
            );
        }

        /**
         * @return \Ganked\API\Handlers\Post\Posts\CommandHandler
         */
        public function createCreateNewPostCommandHandler()
        {
            return new \Ganked\API\Handlers\Post\Posts\CommandHandler(
                new \Ganked\API\Parsers\PostParser,
                $this->getMasterFactory()->createInsertPostCommand()
            );
        }

        /**
         * @return \Ganked\API\Handlers\Post\Posts\QueryHandler
         */
        public function createCreateNewPostQueryHandler()
        {
            return new \Ganked\API\Handlers\Post\Posts\QueryHandler(
                $this->getMasterFactory()->createFetchUserIdForAccessTokenQuery()
            );
        }

        public function createCreateNewUserCommandHandler()
        {
            return new \Ganked\API\Handlers\Post\Users\CommandHandler(
                $this->getMasterFactory()->createInsertUserCommand()
            );
        }

        /**
         * @return \Ganked\API\Handlers\QueryHandler
         */
        public function createQueryHandler()
        {
            return new \Ganked\API\Handlers\QueryHandler;
        }

        /**
         * @return \Ganked\API\Handlers\Post\AccessToken\CommandHandler
         */
        public function createTokenAuthorizationCommandHandler()
        {
            return new \Ganked\API\Handlers\Post\AccessToken\CommandHandler(
                $this->getMasterFactory()->createSaveAccessTokenCommand()
            );
        }

        /**
         * @return \Ganked\API\Handlers\Delete\AccessToken\CommandHandler
         */
        public function createDeleteTokenCommandHandler()
        {
            return new \Ganked\API\Handlers\Delete\AccessToken\CommandHandler(
                $this->getMasterFactory()->createDeleteAccessTokenCommand()
            );
        }

        /**
         * @return \Ganked\API\Handlers\Get\Account\QueryHandler
         */
        public function createGetAccountQueryHandler()
        {
            return new \Ganked\API\Handlers\Get\Account\QueryHandler(
                $this->getMasterFactory()->createFetchAccountWithUsernameQuery(),
                $this->getMasterFactory()->createFetchAccountWithEmailQuery()
            );
        }

        /**
         * @return \Ganked\API\Handlers\Patch\Users\CommandHandler
         */
        public function createUpdateUserCommandHandler()
        {
            return new \Ganked\API\Handlers\Patch\Users\CommandHandler(
                $this->getMasterFactory()->createUpdateUserCommand()
            );
        }

        /**
         * @return \Ganked\API\Handlers\Patch\Users\CommandHandler
         */
        public function createUpdateUserQueryHandler()
        {
            return new \Ganked\API\Handlers\Patch\Users\QueryHandler(
                $this->getMasterFactory()->createFetchUserByIdQuery()
            );
        }

        /**
         * @return \Ganked\API\Handlers\Post\Authenticate\QueryHandler
         */
        public function createAuthenticateQueryHandler()
        {
            return new \Ganked\API\Handlers\Post\Authenticate\QueryHandler(
                $this->getMasterFactory()->createFetchAccountWithEmailQuery(),
                $this->getMasterFactory()->createFetchAccountWithUsernameQuery()
            );
        }

        /**
         * @return \Ganked\API\Handlers\Get\LeagueOfLegends\SummonerFavourite\QueryHandler
         */
        public function createGetFavouriteSummonerQueryHandler()
        {
            return new \Ganked\API\Handlers\Get\LeagueOfLegends\SummonerFavourite\QueryHandler(
                $this->getMasterFactory()->createFetchFavouriteSummonersForUserQuery(),
                $this->getMasterFactory()->createFetchSummonersFromRedisQuery()
            );
        }

        /**
         * @return \Ganked\API\Handlers\Get\LeagueOfLegends\SummonerFavourite\Relationship\QueryHandler
         */
        public function createGetFavouriteSummonerRelationshipQueryHandler()
        {
            return new \Ganked\API\Handlers\Get\LeagueOfLegends\SummonerFavourite\Relationship\QueryHandler(
                $this->getMasterFactory()->createIsFavouritingSummonerQuery()
            );
        }

        /**
         * @return \Ganked\API\Handlers\Get\LeagueOfLegends\SummonerFavourite\Relationship\ResponseHandler
         */
        public function createGetFavouriteSummonerRelationshipResponseHandler()
        {
            return new \Ganked\API\Handlers\Get\LeagueOfLegends\SummonerFavourite\Relationship\ResponseHandler;
        }

        /**
         * @return \Ganked\API\Handlers\Post\SteamAccount\CommandHandler
         */
        public function createAddSteamAccountToUserCommandHandler()
        {
            return new \Ganked\API\Handlers\Post\SteamAccount\CommandHandler(
                $this->getMasterFactory()->createAddSteamAccountToUserCommand()
            );
        }

        /**
         * @return \Ganked\API\Handlers\Get\LeagueOfLegends\SummonerFavourite\ResponseHandler
         */
        public function createGetFavouriteSummonerResponseHandler()
        {
            return new \Ganked\API\Handlers\Get\LeagueOfLegends\SummonerFavourite\ResponseHandler;
        }
    }
}
