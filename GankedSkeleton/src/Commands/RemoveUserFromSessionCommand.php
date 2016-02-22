<?php

/**
 * Copyright (c) Ganked 2015
 * All rights reserved.
 */
 
namespace Ganked\Skeleton\Commands
{

    use Ganked\Skeleton\Session\SessionData;

    class RemoveUserFromSessionCommand
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

        public function execute()
        {
            $this->sessionData->removeAccount();
        }
    }
}
