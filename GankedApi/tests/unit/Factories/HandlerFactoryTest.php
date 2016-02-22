<?php

 /**
 * Copyright (c) Ganked 2015
 * All rights reserved.
 */
 
namespace Ganked\API\Factories
{
    /**
     * @covers Ganked\API\Factories\HandlerFactory
     * @uses Ganked\API\Factories\QueryFactory
     * @uses Ganked\API\Factories\CommandFactory
     * @uses Ganked\API\Factories\BackendFactory
     * @uses Ganked\API\Factories\ServiceFactory
     * @uses Ganked\API\Factories\ReaderFactory
     * @uses \Ganked\API\Handlers\Get\Users\QueryHandler
     * @uses \Ganked\API\Handlers\PreHandler
     * @uses \Ganked\API\Services\AbstractDatabaseService
     * @uses \Ganked\API\Queries\GetUserFromDatabaseQuery
     * @uses \Ganked\API\Readers\TokenReader
     * @uses \Ganked\API\Handlers\Get\Users\Posts\QueryHandler
     * @uses \Ganked\API\Queries\GetPostsForUserQuery
     * @uses \Ganked\API\Handlers\Get\Posts\QueryHandler
     * @uses \Ganked\API\Queries\GetPostByIdQuery
     * @uses \Ganked\API\Queries\FetchPostsByIdsQuery
     * @uses \Ganked\API\Commands\DeleteAccessTokenCommand
     * @uses \Ganked\API\Commands\SaveAccessTokenCommand
     * @uses \Ganked\API\Commands\LikePostCommand
     * @uses \Ganked\API\Handlers\Post\Posts\Likes\CommandHandler
     * @uses \Ganked\API\Handlers\Post\Posts\Likes\QueryHandler
     * @uses \Ganked\API\Queries\HasPostByIdQuery
     * @uses \Ganked\API\Queries\HasUserByIdQuery
     * @uses \Ganked\API\Handlers\Post\Posts\CommandHandler
     * @uses \Ganked\API\Handlers\Post\Posts\QueryHandler
     * @uses \Ganked\API\Queries\FetchUserIdForAccessTokenQuery
     * @uses \Ganked\API\Handlers\Delete\AccessToken\CommandHandler
     * @uses \Ganked\API\Handlers\Post\AccessToken\CommandHandler
     * @uses \Ganked\API\Queries\FetchUserByIdQuery
     * @uses \Ganked\API\Queries\FetchAccountWithEmailQuery
     * @uses \Ganked\API\Queries\FetchAccountWithUsernameQuery
     * @uses \Ganked\API\Handlers\Get\Account\QueryHandler
     * @uses \Ganked\API\Commands\InsertUserCommand
     * @uses \Ganked\API\Handlers\Post\Users\CommandHandler
     * @uses \Ganked\API\Handlers\Patch\Users\QueryHandler
     * @uses \Ganked\API\Handlers\Patch\Users\CommandHandler
     * @uses \Ganked\API\Commands\UpdateUserCommand
     * @uses \Ganked\API\Commands\FavouriteSummonerCommand
     * @uses \Ganked\API\Commands\UnfavouriteSummonerCommand
     * @uses \Ganked\API\Handlers\Post\LeagueOfLegends\SummonerFavourite\CommandHandler
     * @uses \Ganked\API\Handlers\Delete\LeagueOfLegends\SummonerFavourite\CommandHandler
     * @uses \Ganked\API\Handlers\Get\LeagueOfLegends\SummonerFavourite\QueryHandler
     * @uses \Ganked\API\Handlers\Get\LeagueOfLegends\SummonerFavourite\Relationship\QueryHandler
     * @uses \Ganked\API\Queries\FetchFavouriteSummonersForUserQuery
     * @uses \Ganked\API\Queries\IsFavouritingSummonerQuery
     * @uses \Ganked\API\Queries\FetchSummonersFromRedisQuery
     * @uses \Ganked\API\Queries\FetchUserBySteamIdQuery
     * @uses \Ganked\API\Commands\InsertPostCommand
     */
    class HandlerFactoryTest extends GenericFactoryTestHelper
    {
        /**
         * @return array
         */
        public function provideInstanceNames()
        {
            return [
                ['createPreHandler', \Ganked\API\Handlers\PreHandler::class],
                ['createGetUserQueryHandler', \Ganked\API\Handlers\Get\Users\QueryHandler::class],
                ['createGetUserPostsQueryHandler', \Ganked\API\Handlers\Get\Users\Posts\QueryHandler::class],
                ['createResponseHandler', \Ganked\API\Handlers\ResponseHandler::class],
                ['createGetPostQueryHandler', \Ganked\API\Handlers\Get\Posts\QueryHandler::class],
                ['createCommandHandler', \Ganked\API\Handlers\CommandHandler::class],
                ['createLikePostQueryHandler', \Ganked\API\Handlers\Post\Posts\Likes\QueryHandler::class],
                ['createLikePostCommandHandler', \Ganked\API\Handlers\Post\Posts\Likes\CommandHandler::class],
                ['createCreateNewPostCommandHandler', \Ganked\API\Handlers\Post\Posts\CommandHandler::class],
                ['createCreateNewPostQueryHandler', \Ganked\API\Handlers\Post\Posts\QueryHandler::class],
                ['createQueryHandler', \Ganked\API\Handlers\QueryHandler::class],
                ['createTokenAuthorizationCommandHandler', \Ganked\API\Handlers\Post\AccessToken\CommandHandler::class],
                ['createDeleteTokenCommandHandler', \Ganked\API\Handlers\Delete\AccessToken\CommandHandler::class],
                ['createCreateNewUserCommandHandler', \Ganked\API\Handlers\Post\Users\CommandHandler::class],
                ['createGetAccountQueryHandler', \Ganked\API\Handlers\Get\Account\QueryHandler::class],
                ['createUpdateUserCommandHandler', \Ganked\API\Handlers\Patch\Users\CommandHandler::class],
                ['createUpdateUserQueryHandler', \Ganked\API\Handlers\Patch\Users\QueryHandler::class],
                ['createFavouriteSummonerCommandHandler', \Ganked\API\Handlers\Post\LeagueOfLegends\SummonerFavourite\CommandHandler::class],
                ['createUnfavouriteSummonerCommandHandler', \Ganked\API\Handlers\Delete\LeagueOfLegends\SummonerFavourite\CommandHandler::class],
                ['createGetFavouriteSummonerQueryHandler', \Ganked\API\Handlers\Get\LeagueOfLegends\SummonerFavourite\QueryHandler::class],
                ['createGetFavouriteSummonerRelationshipQueryHandler', \Ganked\API\Handlers\Get\LeagueOfLegends\SummonerFavourite\Relationship\QueryHandler::class],
                ['createGetFavouriteSummonerRelationshipResponseHandler', \Ganked\API\Handlers\Get\LeagueOfLegends\SummonerFavourite\Relationship\ResponseHandler::class],
                ['createGetFavouriteSummonerResponseHandler', \Ganked\API\Handlers\Get\LeagueOfLegends\SummonerFavourite\ResponseHandler::class],
            ];
        }
    }
}
