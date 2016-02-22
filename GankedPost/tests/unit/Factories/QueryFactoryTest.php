<?php

/**
 * Copyright (c) Dean Eigenmann 2015
 * All rights reserved.
 */
 
namespace Ganked\Post\Factories
{
    /**
     * @covers Ganked\Post\Factories\QueryFactory
     * @uses Ganked\Post\Factories\BackendFactory
     * @uses \Ganked\Post\Queries\IsVerifiedForBetaQuery
     * @uses \Ganked\Post\Factories\HandlerFactory
     * @uses \Ganked\Post\Queries\HasBetaRequestQuery
     */
    class QueryFactoryTest extends GenericFactoryTestHelper
    {

        /**
         * @return array
         */
        public function provideInstanceNames()
        {
            return [
                ['createIsVerifiedForBetaQuery', \Ganked\Post\Queries\IsVerifiedForBetaQuery::class],
                ['createHasBetaRequestQuery', \Ganked\Post\Queries\HasBetaRequestQuery::class],
            ];
        }
    }
}
