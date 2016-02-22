<?php
/**
 * Copyright (c) Ganked 2015
 * All rights reserved.
 */

namespace Ganked\Frontend\Factories
{

    /**
     * @covers Ganked\Frontend\Factories\CommandFactory
     * @uses Ganked\Frontend\Factories\RouterFactory
     * @uses \Ganked\Frontend\Commands\SaveDefaultLeagueOfLegendsRegionInSessionCommand
     * @uses \Ganked\Frontend\Commands\SaveSteamIdInSessionCommand
     * @uses \Ganked\Frontend\Commands\LockSessionForSteamLoginCommand
     */
    class CommandFactoryTest extends GenericFactoryTestHelper
    {

        /**
         * @return array
         */
        public function provideInstanceNames()
        {
            return [
                ['createSaveDefaultLeagueOfLegendsRegionInSessionCommand', \Ganked\Frontend\Commands\SaveDefaultLeagueOfLegendsRegionInSessionCommand::class],
                ['createLockSessionForSteamLoginCommand', \Ganked\Frontend\Commands\LockSessionForSteamLoginCommand::class],
                ['createSaveSteamIdInSessionCommand', \Ganked\Frontend\Commands\SaveSteamIdInSessionCommand::class],
            ];
        }
    }
}
