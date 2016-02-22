<?php

 /**
 * Copyright (c) Ganked 2015
 * All rights reserved.
 */
 
namespace Ganked\API\Factories
{
    /**
     * @covers Ganked\API\Factories\ControllerFactory
     * @uses Ganked\API\Factories\ServiceFactory
     * @uses Ganked\API\Factories\CommandFactory
     * @uses Ganked\API\Factories\HandlerFactory
     * @uses Ganked\API\Factories\BackendFactory
     * @uses Ganked\API\Factories\ReaderFactory
     * @uses Ganked\API\Factories\QueryFactory
     * @uses \Ganked\API\Readers\TokenReader
     * @uses \Ganked\API\Handlers\Get\Users\QueryHandler
     * @uses \Ganked\API\Controllers\GetController
     * @uses \Ganked\API\Services\AbstractDatabaseService
     * @uses \Ganked\API\Queries\GetUserFromDatabaseQuery
     * @uses \Ganked\API\Handlers\PreHandler
     * @uses \Ganked\API\Handlers\Get\Users\Posts\QueryHandler
     * @uses \Ganked\API\Queries\GetPostsForUserQuery
     * @uses Ganked\API\Controllers\AbstractApiController
     * @uses \Ganked\API\Handlers\Get\Posts\QueryHandler
     * @uses \Ganked\API\Queries\GetPostByIdQuery
     * @uses \Ganked\API\Queries\FetchPostsByIdsQuery
     * @uses \Ganked\API\Queries\HasPostByIdQuery
     * @uses \Ganked\API\Commands\DeleteAccessTokenCommand
     * @uses \Ganked\API\Commands\SaveAccessTokenCommand
     * @uses \Ganked\API\Handlers\Delete\AccessToken\CommandHandler
     * @uses \Ganked\API\Handlers\Post\AccessToken\CommandHandler
     * @uses \Ganked\API\Commands\LikePostCommand
     * @uses \Ganked\API\Handlers\Post\Posts\Likes\CommandHandler
     * @uses \Ganked\API\Handlers\Post\Posts\Likes\QueryHandler
     * @uses \Ganked\API\Queries\HasUserByIdQuery
     * @uses \Ganked\API\Handlers\Post\Posts\CommandHandler
     * @uses \Ganked\API\Handlers\Post\Posts\QueryHandler
     * @uses \Ganked\API\Queries\FetchUserIdForAccessTokenQuery
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
    class ControllerFactoryTest extends GenericFactoryTestHelper
    {
        /**
         * @param       $method
         * @param       $instance
         * @param array $model
         *
         * @throws \PHPUnit_Framework_Exception
         * @dataProvider provideInstanceNames
         */
        public function testCreateInstanceWorks($method, $instance, $model)
        {
            $modelMock = $this->getMockBuilder($model)
                ->disableOriginalConstructor()
                ->getMock();

            $this->assertInstanceOf($instance, call_user_func_array([$this->getMasterFactory(), $method], [$modelMock]));
        }

        /**
         * @return array
         */
        public function provideInstanceNames()
        {
            return [
                ['createGetUserController', \Ganked\API\Controllers\GetController::class, \Ganked\API\Models\ApiModel::class],
                ['createErrorController', \Ganked\API\Controllers\ErrorController::class, \Ganked\API\Models\ApiModel::class],
                ['createGetUserPostsController', \Ganked\API\Controllers\GetController::class, \Ganked\API\Models\ApiModel::class],
                ['createGetPostController', \Ganked\API\Controllers\GetController::class, \Ganked\API\Models\ApiModel::class],
                ['createLikePostController', \Ganked\API\Controllers\GetController::class, \Ganked\API\Models\ApiModel::class],
                ['createCreateNewPostController', \Ganked\API\Controllers\GetController::class, \Ganked\API\Models\ApiModel::class],
                ['createTokenAuthorizationController', \Ganked\API\Controllers\GetController::class, \Ganked\API\Models\ApiModel::class],
                ['createDeleteTokenController', \Ganked\API\Controllers\GetController::class, \Ganked\API\Models\ApiModel::class],
                ['createCreateNewUserController', \Ganked\API\Controllers\GetController::class, \Ganked\API\Models\ApiModel::class],
                ['createGetAccountController', \Ganked\API\Controllers\GetController::class, \Ganked\API\Models\ApiModel::class],
                ['createUpdateUserController', \Ganked\API\Controllers\GetController::class, \Ganked\API\Models\ApiModel::class],
                ['createFavouriteSummonerController', \Ganked\API\Controllers\PostController::class, \Ganked\API\Models\ApiModel::class],
                ['createUnfavouriteSummonerController', \Ganked\API\Controllers\PostController::class, \Ganked\API\Models\ApiModel::class],
                ['createGetFavouriteSummonerController', \Ganked\API\Controllers\GetController::class, \Ganked\API\Models\MongoCursorModel::class],
                ['createGetFavouriteSummonerRelationshipController', \Ganked\API\Controllers\GetController::class, \Ganked\API\Models\ApiModel::class],
            ];
        }
    }
}
