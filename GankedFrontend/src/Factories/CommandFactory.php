<?php

/**
 * Copyright (c) Ganked 2015
 * All rights reserved.
 */

namespace Ganked\Frontend\Factories
{

    class CommandFactory extends \Ganked\Skeleton\Factories\CommandFactory
    {
        /**
         * @return \Ganked\Frontend\Commands\SaveDefaultLeagueOfLegendsRegionInSessionCommand
         */
        public function createSaveDefaultLeagueOfLegendsRegionInSessionCommand()
        {
            return new \Ganked\Frontend\Commands\SaveDefaultLeagueOfLegendsRegionInSessionCommand(
                $this->getSessionData()
            );
        }

        /**
         * @return \Ganked\Frontend\Commands\LockSessionForSteamLoginCommand
         */
        public function createLockSessionForSteamLoginCommand()
        {
            return new \Ganked\Frontend\Commands\LockSessionForSteamLoginCommand(
                $this->getSessionData()
            );
        }

        /**
         * @return \Ganked\Frontend\Commands\SaveSteamIdInSessionCommand
         */
        public function createSaveSteamIdInSessionCommand()
        {
            return new \Ganked\Frontend\Commands\SaveSteamIdInSessionCommand(
                $this->getSessionData()
            );
        }
    }
}
