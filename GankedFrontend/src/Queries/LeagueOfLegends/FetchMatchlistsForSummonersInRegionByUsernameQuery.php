<?php

/**
 * Copyright (c) Ganked 2015
 * All rights reserved.
 */

namespace Ganked\Frontend\Queries
{

    use Ganked\Library\ValueObjects\LeagueOfLegends\Region;

    class FetchMatchlistsForSummonersInRegionByUsernameQuery extends AbstractLeagueOfLegendsQuery
    {
        public function execute(array $summoners = [], Region $region)
        {
            return json_decode($this->getGateway()->getMatchlistsForSummonersInRegionByUsername($summoners, (string) $region)->getBody(), true);
        }

    }
}
