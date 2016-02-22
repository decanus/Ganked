<?php

/**
 * Copyright (c) Dean Eigenmann 2015
 * All rights reserved.
 */
 
namespace Ganked\Frontend\Factories
{

    use Ganked\Skeleton\Factories\AbstractFactory;

    class MapperFactory extends AbstractFactory
    {
        /**
         * @return \Ganked\Frontend\Mappers\LeagueOfLegendsSummonerMapper
         */
        public function createLeagueOfLegendsSummonerMapper()
        {
            return new \Ganked\Frontend\Mappers\LeagueOfLegendsSummonerMapper;
        }

        /**
         * @return \Ganked\Frontend\Mappers\CounterStrikeUserMapper
         */
        public function createCounterStrikeUserMapper()
        {
            return new \Ganked\Frontend\Mappers\CounterStrikeUserMapper(
                $this->getMasterFactory()->createCounterStrikeGateway()
            );

        }

        /**
         * @return \Ganked\Frontend\Mappers\LeagueOfLegendsRecentGamesMapper
         */
        public function createLeagueOfLegendsRecentGamesMapper()
        {
            return new \Ganked\Frontend\Mappers\LeagueOfLegendsRecentGamesMapper(
                $this->getMasterFactory()->createLeagueOfLegendsDataPoolReader(),
                $this->getMasterFactory()->createLeagueOfLegendsSummonerRoleMapper()
            );
        }

        /**
         * @return \Ganked\Frontend\Mappers\UserProfileMapper
         */
        public function createUserProfileMapper()
        {
            return new \Ganked\Frontend\Mappers\UserProfileMapper(
                $this->getMasterFactory()->createHasProfileForUsernameQuery(),
                $this->getMasterFactory()->createFetchProfileForUsernameQuery()
            );
        }

        /**
         * @return \Ganked\Frontend\Mappers\LeagueOfLegendsSummonerRunesMapper
         */
        public function createLeagueOfLegendsSummonerRunesMapper()
        {
            return new \Ganked\Frontend\Mappers\LeagueOfLegendsSummonerRunesMapper(
                $this->getMasterFactory()->createLeagueOfLegendsDataPoolReader()
            );
        }

        /**
         * @return \Ganked\Frontend\Mappers\LeagueOfLegendsMultiSearchMapper
         */
        public function createLeagueOfLegendsMultiSearchMapper()
        {
            return new \Ganked\Frontend\Mappers\LeagueOfLegendsMultiSearchMapper(
                $this->getMasterFactory()->createLeagueOfLegendsDataPoolReader(),
                $this->getMasterFactory()->createLeagueOfLegendsSummonerRoleMapper()
            );
        }

        /**
         * @return \Ganked\Frontend\Mappers\LeagueOfLegendsSummonerRoleMapper
         */
        public function createLeagueOfLegendsSummonerRoleMapper()
        {
            return new \Ganked\Frontend\Mappers\LeagueOfLegendsSummonerRoleMapper(
                $this->getMasterFactory()->createLeagueOfLegendsDataPoolReader()
            );
        }

        /**
         * @return \Ganked\Frontend\Mappers\LeagueOfLegendsMatchOverviewMapper
         */
        public function createLeagueOfLegendsMatchOverviewMapper()
        {
            return new \Ganked\Frontend\Mappers\LeagueOfLegendsMatchOverviewMapper(
                $this->getMasterFactory()->createLeagueOfLegendsSummonerRoleMapper(),
                $this->getMasterFactory()->createLeagueOfLegendsDataPoolReader()
            );
        }

        /**
         * @return \Ganked\Frontend\Mappers\LeagueOfLegendsCurrentGameMapper
         */
        public function createLeagueOfLegendsCurrentGameMapper()
        {
            return new \Ganked\Frontend\Mappers\LeagueOfLegendsCurrentGameMapper(
                $this->getMasterFactory()->createLeagueOfLegendsDataPoolReader()
            );
        }
    }
}
