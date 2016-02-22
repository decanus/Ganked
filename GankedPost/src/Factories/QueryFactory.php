<?php

/**
 * Copyright (c) Dean Eigenmann 2015
 * All rights reserved.
 */
 
namespace Ganked\Post\Factories
{
    class QueryFactory extends \Ganked\Skeleton\Factories\QueryFactory
    {
        /**
         * @return \Ganked\Post\Queries\IsVerifiedForBetaQuery
         */
        public function createIsVerifiedForBetaQuery()
        {
            return new \Ganked\Post\Queries\IsVerifiedForBetaQuery(
                $this->getMasterFactory()->createAccountGateway()
            );
        }

        /**
         * @return \Ganked\Post\Queries\HasBetaRequestQuery
         */
        public function createHasBetaRequestQuery()
        {
            return new \Ganked\Post\Queries\HasBetaRequestQuery(
                $this->getMasterFactory()->createAccountGateway()
            );
        }
    }
}
