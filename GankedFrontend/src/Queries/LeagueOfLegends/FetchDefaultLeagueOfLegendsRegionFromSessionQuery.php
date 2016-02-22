<?php

/**
 * Copyright (c) Ganked 2015
 * All rights reserved.
 */

namespace Ganked\Frontend\Queries
{

    use Ganked\Skeleton\Session\SessionData;

    class FetchDefaultLeagueOfLegendsRegionFromSessionQuery
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
         * @return \Ganked\Library\ValueObjects\LeagueOfLegends\Region
         */
        public function execute()
        {
            return $this->sessionData->getDefaultLeagueOfLegendsRegion();
        }
    }
}
