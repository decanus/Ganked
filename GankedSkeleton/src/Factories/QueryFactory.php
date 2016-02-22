<?php

/**
 * Copyright (c) Dean Eigenmann 2015
 * All rights reserved.
 */
 
namespace Ganked\Skeleton\Factories
{

    use Ganked\Skeleton\Session\SessionData;

    class QueryFactory extends AbstractFactory
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
         * @return \Ganked\Skeleton\Queries\GetDomFromFileQuery
         */
        public function createGetDomFromFileQuery()
        {
            return new \Ganked\Skeleton\Queries\GetDomFromFileQuery(
                $this->getMasterFactory()->createFileBackend()
            );
        }

        /**
         * @return \Ganked\Skeleton\Queries\FetchSessionCookieQuery
         */
        public function createFetchSessionCookieQuery()
        {
            return new \Ganked\Skeleton\Queries\FetchSessionCookieQuery(
                $this->getMasterFactory()->createSession()
            );
        }

        public function createFetchPreviousUriQuery()
        {
            return new \Ganked\Skeleton\Queries\FetchPreviousUriQuery(
                $this->sessionData
            );
        }

        /**
         * @return \Ganked\Skeleton\Queries\IsSessionStartedQuery
         */
        public function createIsSessionStartedQuery()
        {
            return new \Ganked\Skeleton\Queries\IsSessionStartedQuery(
                $this->getMasterFactory()->createSession()
            );
        }

        /**
         * @return \Ganked\Skeleton\Queries\SessionHasUserQuery
         */
        public function createSessionHasUserQuery()
        {
            return new \Ganked\Skeleton\Queries\SessionHasUserQuery(
                $this->sessionData
            );
        }

        /**
         * @return \Ganked\Skeleton\Queries\FetchUserFromSessionQuery
         */
        public function createFetchUserFromSessionQuery()
        {
            return new \Ganked\Skeleton\Queries\FetchUserFromSessionQuery(
                $this->sessionData
            );
        }

        /**
         * @return \Ganked\Skeleton\Queries\FetchAccountFromSessionQuery
         */
        public function createFetchAccountFromSessionQuery()
        {
            return new \Ganked\Skeleton\Queries\FetchAccountFromSessionQuery(
                $this->sessionData
            );
        }

        /**
         * @return \Ganked\Skeleton\Queries\FetchUserHashQuery
         */
        public function createFetchUserHashQuery()
        {
            return new \Ganked\Skeleton\Queries\FetchUserHashQuery(
                $this->getMasterFactory()->createAccountGateway()
            );
        }

        /**
         * @return \Ganked\Skeleton\Queries\FetchMatchForRegionQuery
         */
        public function createFetchMatchForRegionQuery()
        {
            return new \Ganked\Skeleton\Queries\FetchMatchForRegionQuery(
                $this->getMasterFactory()->createLoLGateway()
            );
        }

        /**
         * @return \Ganked\Skeleton\Queries\HasUserBySteamIdQuery
         */
        public function createHasUserBySteamIdQuery()
        {
            return new \Ganked\Skeleton\Queries\HasUserBySteamIdQuery(
                $this->getMasterFactory()->createGankedApiGateway()
            );
        }

        /**
         * @return \Ganked\Skeleton\Queries\FetchSteamIdFromSessionQuery
         */
        public function createFetchSteamIdFromSessionQuery()
        {
            return new \Ganked\Skeleton\Queries\FetchSteamIdFromSessionQuery(
                $this->getSessionData()
            );
        }

        /**
         * @return \Ganked\Skeleton\Queries\FetchUserWithSteamIdQuery
         */
        public function createFetchUserWithSteamIdQuery()
        {
            return new \Ganked\Skeleton\Queries\FetchUserWithSteamIdQuery(
                $this->getMasterFactory()->createGankedApiGateway()
            );
        }

        /**
         * @return \Ganked\Skeleton\Queries\FetchAccountQuery
         */
        public function createFetchAccountQuery()
        {
            return new \Ganked\Skeleton\Queries\FetchAccountQuery(
                $this->getMasterFactory()->createGankedApiGateway()
            );
        }


        /**
         * @return \Ganked\Skeleton\Queries\FetchUserByIdQuery
         */
        public function createFetchUserByIdQuery()
        {
            return new \Ganked\Skeleton\Queries\FetchUserByIdQuery(
                $this->getMasterFactory()->createGankedApiGateway()
            );
        }

        /**
         * @return SessionData
         */
        protected function getSessionData()
        {
            return $this->sessionData;
        }
    }
}
