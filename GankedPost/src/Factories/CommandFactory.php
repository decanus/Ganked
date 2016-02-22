<?php

/**
 * Copyright (c) Dean Eigenmann 2015
 * All rights reserved.
 */
 
namespace Ganked\Post\Factories
{
    class CommandFactory extends \Ganked\Skeleton\Factories\CommandFactory
    {
        /**
         * @return \Ganked\Post\Commands\LoginUserCommand
         */
        public function createLoginUserCommand()
        {
            return new \Ganked\Post\Commands\LoginUserCommand(
                $this->getSessionData()
            );
        }

        /**
         * @return \Ganked\Post\Commands\InsertUserCommand
         */
        public function createInsertUserCommand()
        {
            return new \Ganked\Post\Commands\InsertUserCommand(
                $this->getMasterFactory()->createGankedApiGateway()
            );
        }

        /**
         * @return \Ganked\Post\Commands\InsertSteamUserCommand
         */
        public function createInsertSteamUserCommand()
        {
            return new \Ganked\Post\Commands\InsertSteamUserCommand(
                $this->getMasterFactory()->createGankedApiGateway()
            );
        }

        /**
         * @return \Ganked\Post\Commands\VerifyUserCommand
         */
        public function createVerifyUserCommand()
        {
            return new \Ganked\Post\Commands\VerifyUserCommand(
                $this->getMasterFactory()->createAccountGateway()
            );
        }

        /**
         * @return \Ganked\Post\Commands\UpdateUserHashCommand
         */
        public function createUpdateUserHashCommand()
        {
            return new \Ganked\Post\Commands\UpdateUserHashCommand(
                $this->getMasterFactory()->createAccountGateway()
            );
        }

        /**
         * @return \Ganked\Post\Commands\CreateNewPostCommand
         */
        public function createCreateNewPostCommand()
        {
            return new \Ganked\Post\Commands\CreateNewPostCommand(
                $this->getMasterFactory()->createGankedApiGateway()
            );
        }

        /**
         * @return \Ganked\Post\Commands\UpdateUserPasswordCommand
         */
        public function createUpdateUserPasswordCommand()
        {
            return new \Ganked\Post\Commands\UpdateUserPasswordCommand(
                $this->getMasterFactory()->createAccountGateway()
            );
        }

        /**
         * @return \Ganked\Post\Commands\FavouriteSummonerCommand
         */
        public function createFavouriteSummonerCommand()
        {
            return new \Ganked\Post\Commands\FavouriteSummonerCommand(
                $this->getMasterFactory()->createFavouritesGateway()
            );
        }

        /**
         * @return \Ganked\Post\Commands\UnfavouriteSummonerCommand
         */
        public function createUnfavouriteSummonerCommand()
        {
            return new \Ganked\Post\Commands\UnfavouriteSummonerCommand(
                $this->getMasterFactory()->createFavouritesGateway()
            );
        }

        /**
         * @return \Ganked\Post\Commands\UnlockSessionFromSteamLoginCommand
         */
        public function createUnlockSessionFromSteamLoginCommand()
        {
            return new \Ganked\Post\Commands\UnlockSessionFromSteamLoginCommand(
                $this->getSessionData()
            );
        }

        /**
         * @return \Ganked\Post\Commands\RemoveSteamIdFromSessionCommand
         */
        public function createRemoveSteamIdFromSessionCommand()
        {
            return new \Ganked\Post\Commands\RemoveSteamIdFromSessionCommand(
                $this->getSessionData()
            );
        }

        /**
         * @return \Ganked\Post\Commands\ConnectSteamAccountToUserCommand
         */
        public function createConnectSteamAccountToUserCommand()
        {
            return new \Ganked\Post\Commands\ConnectSteamAccountToUserCommand(
                $this->getMasterFactory()->createGankedApiGateway()
            );
        }

        /**
         * @return \Ganked\Post\Commands\AuthenticationCommand
         */
        public function createAuthenticationCommand()
        {
            return new \Ganked\Post\Commands\AuthenticationCommand(
                $this->getMasterFactory()->createGankedApiGateway()
            );
        }

    }
}
