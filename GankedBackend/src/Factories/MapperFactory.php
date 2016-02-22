<?php

/**
 * Copyright (c) Ganked 2015
 * All rights reserved.
 */
 
namespace Ganked\Backend\Factories
{

    use Ganked\Skeleton\Factories\AbstractFactory;

    class MapperFactory extends AbstractFactory
    {
        /**
         * @return \Ganked\Backend\Mappers\LeagueOfLegendsLeaderboardMapper
         */
        public function createLeagueOfLegendsLeaderboardMapper()
        {
            return new \Ganked\Backend\Mappers\LeagueOfLegendsLeaderboardMapper;
        }
    }
}
