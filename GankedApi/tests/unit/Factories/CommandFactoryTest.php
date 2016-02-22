<?php

/**
 * Copyright (c) Ganked 2015
 * All rights reserved.
 */
 
namespace Ganked\API\Factories
{
    /**
     * @covers Ganked\API\Factories\CommandFactory
     * @uses Ganked\API\Factories\BackendFactory
     * @uses Ganked\API\Factories\ServiceFactory
     * @uses \Ganked\API\Commands\DeleteAccessTokenCommand
     * @uses \Ganked\API\Commands\SaveAccessTokenCommand
     * @uses \Ganked\API\Commands\LikePostCommand
     * @uses \Ganked\API\Services\AbstractDatabaseService
     * @uses \Ganked\API\Commands\InsertUserCommand
     * @uses \Ganked\API\Commands\UpdateUserCommand
     * @uses \Ganked\API\Commands\FavouriteSummonerCommand
     * @uses \Ganked\API\Commands\UnfavouriteSummonerCommand
     * @uses \Ganked\API\Commands\InsertPostCommand
     */
    class CommandFactoryTest extends GenericFactoryTestHelper
    {

        /**
         * @return array
         */
        public function provideInstanceNames()
        {
            return [
                ['createLikePostCommand', \Ganked\API\Commands\LikePostCommand::class],
                ['createSaveAccessTokenCommand', \Ganked\API\Commands\SaveAccessTokenCommand::class],
                ['createDeleteAccessTokenCommand', \Ganked\API\Commands\DeleteAccessTokenCommand::class],
                ['createInsertUserCommand', \Ganked\API\Commands\InsertUserCommand::class],
                ['createInsertPostCommand', \Ganked\API\Commands\InsertPostCommand::class],
                ['createUpdateUserCommand', \Ganked\API\Commands\UpdateUserCommand::class],
                ['createFavouriteSummonerCommand', \Ganked\API\Commands\FavouriteSummonerCommand::class],
                ['createUnfavouriteSummonerCommand', \Ganked\API\Commands\UnfavouriteSummonerCommand::class],
            ];
        }
    }
}
