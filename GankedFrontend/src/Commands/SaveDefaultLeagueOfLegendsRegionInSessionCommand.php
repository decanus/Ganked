<?php

/**
 * Copyright (c) Ganked 2015
 * All rights reserved.
 */

namespace Ganked\Frontend\Commands
{

    use Ganked\Library\ValueObjects\LeagueOfLegends\Region;
    use Ganked\Skeleton\Session\SessionData;

    class SaveDefaultLeagueOfLegendsRegionInSessionCommand
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
         * @param Region $region
         */
        public function execute(Region $region)
        {
            if ($this->sessionData->hasDefaultLeagueOfLegendsRegion()) {
                $this->sessionData->removeDefaultLeagueOfLegendsRegion();
            }

            $this->sessionData->setDefaultLeagueOfLegendsRegion($region);
        }
    }
}
