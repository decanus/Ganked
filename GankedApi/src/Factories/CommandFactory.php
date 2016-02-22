<?php

/**
 * Copyright (c) Ganked 2015
 * All rights reserved.
 */
 
namespace Ganked\API\Factories
{
    use Ganked\Skeleton\Factories\AbstractFactory;

    class CommandFactory extends AbstractFactory
    {
        /**
         * @return \Ganked\API\Commands\LikePostCommand
         */
        public function createLikePostCommand()
        {
            return new \Ganked\API\Commands\LikePostCommand(
                $this->getMasterFactory()->createPostsService()
            );
        }

        /**
         * @return \Ganked\API\Commands\LikePostCommand
         */
        public function createInsertPostCommand()
        {
            return new \Ganked\API\Commands\InsertPostCommand(
                $this->getMasterFactory()->createPostsService()
            );
        }

        /**
         * @return \Ganked\API\Commands\SaveAccessTokenCommand
         */
        public function createSaveAccessTokenCommand()
        {
            return new \Ganked\API\Commands\SaveAccessTokenCommand(
                $this->getMasterFactory()->createRedisBackend()

            );
        }

        /**
         * @return \Ganked\API\Commands\DeleteAccessTokenCommand
         */
        public function createDeleteAccessTokenCommand()
        {
            return new \Ganked\API\Commands\DeleteAccessTokenCommand(
                $this->getMasterFactory()->createRedisBackend()
            );
        }

        /**
         * @return \Ganked\API\Commands\InsertUserCommand
         */
        public function createInsertUserCommand()
        {
            return new \Ganked\API\Commands\InsertUserCommand(
                $this->getMasterFactory()->createUserService()
            );
        }

        /**
         * @return \Ganked\API\Commands\UpdateUserCommand
         */
        public function createUpdateUserCommand()
        {
            return new \Ganked\API\Commands\UpdateUserCommand(
                $this->getMasterFactory()->createUserService()
            );
        }

        /**
         * @return \Ganked\API\Commands\FavouriteSummonerCommand
         */
        public function createFavouriteSummonerCommand()
        {
            return new \Ganked\API\Commands\FavouriteSummonerCommand(
                $this->getMasterFactory()->createFavouriteService()
            );
        }

        /**
         * @return \Ganked\API\Commands\UnfavouriteSummonerCommand
         */
        public function createUnfavouriteSummonerCommand()
        {
            return new \Ganked\API\Commands\UnfavouriteSummonerCommand(
                $this->getMasterFactory()->createFavouriteService()
            );
        }

        /**
         * @return \Ganked\API\Commands\AddSteamAccountToUserCommand
         */
        public function createAddSteamAccountToUserCommand()
        {
            return new \Ganked\API\Commands\AddSteamAccountToUserCommand(
                $this->getMasterFactory()->createUserService()
            );
        }
    }
}
