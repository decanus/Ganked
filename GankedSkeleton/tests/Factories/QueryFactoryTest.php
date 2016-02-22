<?php

/**
 * Copyright (c) Dean Eigenmann 2015
 * All rights reserved.
 */
 
namespace Ganked\Skeleton\Factories
{
    /**
     * @covers Ganked\Skeleton\Factories\QueryFactory
     * @covers Ganked\Skeleton\Factories\AbstractFactory
     * @uses Ganked\Skeleton\Factories\BackendFactory
     * @uses Ganked\Skeleton\Factories\MasterFactory
     * @uses Ganked\Skeleton\Factories\SessionFactory
     * @uses Ganked\Skeleton\Factories\SessionFactory
     * @uses \Ganked\Skeleton\Session\Session
     * @uses \Ganked\Skeleton\Session\SessionDataPool
     * @uses \Ganked\Skeleton\Queries\GetDomFromFileQuery
     * @uses \Ganked\Skeleton\Queries\FetchSessionCookieQuery
     * @uses \Ganked\Skeleton\Queries\FetchPreviousUriQuery
     * @uses \Ganked\Skeleton\Queries\IsSessionStartedQuery
     * @uses \Ganked\Skeleton\Factories\CommandFactory
     * @uses \Ganked\Skeleton\Queries\SessionHasUserQuery
     * @uses \Ganked\Skeleton\Queries\FetchUserFromSessionQuery
     * @uses \Ganked\Skeleton\Queries\FetchAccountFromSessionQuery
     */
    class QueryFactoryTest extends GenericFactoryTestHelper
    {

        /**
         * @return array
         */
        public function provideInstanceNames()
        {
            return [
                ['createGetDomFromFileQuery', \Ganked\Skeleton\Queries\GetDomFromFileQuery::class],
                ['createFetchSessionCookieQuery', \Ganked\Skeleton\Queries\FetchSessionCookieQuery::class],
                ['createFetchPreviousUriQuery', \Ganked\Skeleton\Queries\FetchPreviousUriQuery::class],
                ['createIsSessionStartedQuery', \Ganked\Skeleton\Queries\IsSessionStartedQuery::class],
                ['createSessionHasUserQuery', \Ganked\Skeleton\Queries\SessionHasUserQuery::class],
                ['createFetchUserFromSessionQuery', \Ganked\Skeleton\Queries\FetchUserFromSessionQuery::class],
                ['createFetchAccountFromSessionQuery', \Ganked\Skeleton\Queries\FetchAccountFromSessionQuery::class],
            ];
        }
    }
}
