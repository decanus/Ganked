<?php

/**
 * Copyright (c) Dean Eigenmann 2015
 * All rights reserved.
 */
 
namespace Ganked\Frontend\Mappers
{

    use Ganked\Frontend\DataObjects\Summoner;
    use Ganked\Library\ValueObjects\LeagueOfLegends\Region;

    class LeagueOfLegendsSummonerMapper
    {
        /**
         * @param array $summoner
         *
         * @return Summoner
         * @throws \Exception
         */
        public function map(array $summoner = [])
        {
            return new Summoner(
                $summoner['id'],
                $summoner['name'],
                $summoner['summonerLevel'],
                $summoner['profileIconId'],
                new Region($summoner['region']),
                $summoner['ttl']
            );
        }
    }
}
