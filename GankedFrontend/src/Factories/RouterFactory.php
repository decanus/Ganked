<?php

/**
 * Copyright (c) Dean Eigenmann 2015
 * All rights reserved.
 */
 
namespace Ganked\Frontend\Factories
{

    use Ganked\Skeleton\Factories\AbstractFactory;
    use Ganked\Skeleton\Session\SessionData;

    class RouterFactory extends AbstractFactory
    {
        /**
         * @var SessionData
         */
        private $sessionData;

        /**
         * @param SessionData $sessionData
         */
        public function __construct(SessionData $sessionData)
        {
            $this->sessionData = $sessionData;
        }

        /**
         * @return \Ganked\Frontend\Routers\ErrorPageRouter
         */
        public function createErrorPageRouter()
        {
            return new \Ganked\Frontend\Routers\ErrorPageRouter($this->getMasterFactory());
        }

        /**
         * @return \Ganked\Frontend\Routers\StaticPageRouter
         */
        public function createStaticPageRouter()
        {
            return new \Ganked\Frontend\Routers\StaticPageRouter(
                $this->getMasterFactory(),
                $this->getMasterFactory()->createDataPoolReader(),
                $this->sessionData
            );
        }

        /**
         * @return \Ganked\Frontend\Routers\SearchPageRouter
         */
        public function createSearchPageRouter()
        {
            return new \Ganked\Frontend\Routers\SearchPageRouter(
                $this->getMasterFactory()
            );
        }

        /**
         * @return \Ganked\Frontend\Routers\AccountPageRouter
         */
        public function createAccountPageRouter()
        {
            return new \Ganked\Frontend\Routers\AccountPageRouter(
                $this->getMasterFactory(),
                $this->sessionData
            );
        }

        /**
         * @return \Ganked\Frontend\Routers\LeagueOfLegendsPageRouter
         */
        public function createLeagueOfLegendsPageRouter()
        {
            return new \Ganked\Frontend\Routers\LeagueOfLegendsPageRouter(
                $this->getMasterFactory(),
                $this->getMasterFactory()->createLeagueOfLegendsReader()
            );
        }

        /**
         * @return \Ganked\Frontend\Routers\CounterStrikePageRouter
         */
        public function createCounterStrikePageRouter()
        {
            return new \Ganked\Frontend\Routers\CounterStrikePageRouter(
                $this->getMasterFactory(),
                $this->getMasterFactory()->createCounterStrikeReader()
            );
        }

        /**
         * @return \Ganked\Frontend\Routers\SteamLoginRouter
         */
        public function createSteamLoginRouter()
        {
            return new \Ganked\Frontend\Routers\SteamLoginRouter(
                $this->getMasterFactory(),
                $this->sessionData
            );
        }

        /**
         * @return \Ganked\Frontend\Routers\UserPageRouter
         */
        public function createUserPageRouter()
        {
            return new \Ganked\Frontend\Routers\UserPageRouter(
                $this->getMasterFactory(),
                $this->getMasterFactory()->createUserReader()
            );

        }

        /**
         * @return \Ganked\Frontend\Routers\RedirectRouter
         */
        public function createRedirectRouter()
        {
            return new \Ganked\Frontend\Routers\RedirectRouter(
                $this->getMasterFactory(),
                $this->getMasterFactory()->createUrlRedirectReader()
            );
        }
    }
}
