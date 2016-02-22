<?php

/**
 * Copyright (c) Ganked 2015
 * All rights reserved.
 */

namespace Ganked\Frontend\Commands
{

    use Ganked\Library\ValueObjects\Steam\SteamId;
    use Ganked\Skeleton\Session\SessionData;

    class SaveSteamIdInSessionCommand
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
         * @param SteamId $steamId
         */
        public function execute(SteamId $steamId)
        {
            if ($this->sessionData->hasSteamId()) {
                $this->sessionData->removeSteamId();
            }

            $this->sessionData->setSteamId($steamId);
        }
    }
}
