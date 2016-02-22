<?php

/**
 * Copyright (c) Ganked 2015
 * All rights reserved.
 */

namespace Ganked\Post\Commands
{

    use Ganked\Skeleton\Session\SessionData;

    class UnlockSessionFromSteamLoginCommand
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
            if (!$this->sessionData->isSteamLoginLocked()) {
                return;
            }

            $this->sessionData->unlockSessionFromSteamLogin();
        }
    }
}
