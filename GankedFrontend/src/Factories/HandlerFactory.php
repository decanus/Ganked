<?php

/**
 * Copyright (c) Dean Eigenmann 2015
 * All rights reserved.
 */
 
namespace Ganked\Frontend\Factories
{

    use Ganked\Skeleton\Factories\AbstractFactory;

    class HandlerFactory extends AbstractFactory
    {
        /**
         * @return \Ganked\Frontend\Handlers\LeagueOfLegendsSearchHandler
         */
        public function createLeagueOfLegendsSearchHandler()
        {
            return new \Ganked\Frontend\Handlers\LeagueOfLegendsSearchHandler(
                $this->getMasterFactory()->createFetchSummonersByNameQuery(),
                $this->getMasterFactory()->createFetchSummonerForRegionByNameQuery(),
                $this->getMasterFactory()->createSaveDefaultLeagueOfLegendsRegionInSessionCommand(),
                $this->getMasterFactory()->createFetchUserFavouriteSummonersQuery()
            );
        }

        /**
         * @return \Ganked\Frontend\Handlers\CommandHandler
         */
        public function createCommandHandler()
        {
            return new \Ganked\Frontend\Handlers\CommandHandler;
        }

        /**
         * @return \Ganked\Frontend\Handlers\PreHandler
         */
        public function createPreHandler()
        {
            return new \Ganked\Frontend\Handlers\PreHandler;
        }

        /**
         * @return \Ganked\Frontend\Handlers\QueryHandler
         */
        public function createQueryHandler()
        {
            return new \Ganked\Frontend\Handlers\QueryHandler;
        }

        /**
         * @return \Ganked\Frontend\Handlers\TransformationHandler
         */
        public function createTransformationHandler()
        {
            return new \Ganked\Frontend\Handlers\TransformationHandler;
        }

        /**
         * @return \Ganked\Frontend\Handlers\Get\ResponseHandler
         */
        public function createGetResponseHandler()
        {
            return new \Ganked\Frontend\Handlers\Get\ResponseHandler(
                $this->getMasterFactory()->createIsSessionStartedQuery(),
                $this->getMasterFactory()->createFetchSessionCookieQuery()
            );
        }

        /**
         * @return \Ganked\Frontend\Handlers\Get\Account\QueryHandler
         */
        public function createAccountPageQueryHandler()
        {
            return new \Ganked\Frontend\Handlers\Get\Account\QueryHandler(
                $this->getMasterFactory()->createFetchAccountQuery()
            );
        }

        /**
         * @return \Ganked\Frontend\Handlers\Get\Account\QueryHandler
         */
        public function createAccountPageTransformationHandler()
        {
            return new \Ganked\Frontend\Handlers\Get\TransformationHandler(
                $this->getMasterFactory()->createAccountPageRenderer()
            );
        }

        /**
         * @return \Ganked\Frontend\Handlers\Get\TransformationHandler
         */
        public function createSteamConnectTransformationHandler()
        {
            return new \Ganked\Frontend\Handlers\Get\TransformationHandler(
                $this->getMasterFactory()->createSteamConnectPageRenderer()
            );
        }

        /**
         * @return \Ganked\Frontend\Handlers\Get\Steam\Connect\PreHandler
         * @throws \Exception
         */
        public function createSteamConnectPreHandler()
        {
            return new \Ganked\Frontend\Handlers\Get\Steam\Connect\PreHandler(
                new \LightOpenID($this->getMasterFactory()->getConfiguration()->get('domain'))
            );
        }

        /**
         * @return \Ganked\Frontend\Handlers\Get\Steam\Connect\QueryHandler
         */
        public function createSteamConnectQueryHandler()
        {
            return new \Ganked\Frontend\Handlers\Get\Steam\Connect\QueryHandler(
                $this->getMasterFactory()->createHasUserBySteamIdQuery()
            );
        }

        /**
         * @return \Ganked\Frontend\Handlers\Get\Steam\Connect\CommandHandler
         */
        public function createSteamConnectCommandHandler()
        {
            return new \Ganked\Frontend\Handlers\Get\Steam\Connect\CommandHandler(
                $this->getMasterFactory()->createSaveSteamIdInSessionCommand()
            );
        }

        /**
         * @return \Ganked\Frontend\Handlers\Get\PostHandler
         */
        public function createGetPostHandler()
        {
            return new \Ganked\Frontend\Handlers\Get\PostHandler(
                $this->getMasterFactory()->createWriteSessionCommand()
            );
        }
    }
}
