<?php

/**
 * Copyright (c) Ganked 2015
 * All rights reserved.
 */
 
namespace Ganked\Skeleton\Queries
{

    use Ganked\Skeleton\Session\SessionData;

    class FetchUserFromSessionQuery
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
         * @return array
         */
        public function execute()
        {
            return $this->sessionData->getUser();
        }
    }
}
