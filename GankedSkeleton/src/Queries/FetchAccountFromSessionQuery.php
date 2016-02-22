<?php

/**
 * Copyright (c) Ganked 2015
 * All rights reserved.
 */

namespace Ganked\Skeleton\Queries
{

    use Ganked\Skeleton\Session\SessionData;

    class FetchAccountFromSessionQuery
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
         * @return \Ganked\Library\DataObjects\Accounts\AccountInterface
         */
        public function execute()
        {
            return $this->sessionData->getAccount();
        }
    }
}
