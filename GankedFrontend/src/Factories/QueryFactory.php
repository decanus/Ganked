<?php

/**
 * Copyright (c) Dean Eigenmann 2015
 * All rights reserved.
 */
 
namespace Ganked\Frontend\Factories
{
    class QueryFactory extends \Ganked\Skeleton\Factories\QueryFactory
    {
        /**
         * @return \Ganked\Frontend\Queries\FetchSummonersByNameQuery
         */
        public function createFetchSummonersByNameQuery()
        {
            return new \Ganked\Frontend\Queries\FetchSummonersByNameQuery(
                $this->getMasterFactory()->createLoLGateway()
            );
        }

        /**
         * @return \Ganked\Frontend\Queries\FetchRecentGamesForSummonerQuery
         */
        public function createFetchRecentGamesForSummonerQuery()
        {
            return new \Ganked\Frontend\Queries\FetchRecentGamesForSummonerQuery(
                $this->getMasterFactory()->createLoLGateway()
            );
        }

        /**
         * @return \Ganked\Frontend\Queries\FetchSummonerForRegionByNameQuery
         */
        public function createFetchSummonerForRegionByNameQuery()
        {
            return new \Ganked\Frontend\Queries\FetchSummonerForRegionByNameQuery(
                $this->getMasterFactory()->createLoLGateway()
            );
        }

        /**
         * @return \Ganked\Frontend\Queries\Social\HasProfileForUsernameQuery
         */
        public function createHasProfileForUsernameQuery()
        {
            return new \Ganked\Frontend\Queries\Social\HasProfileForUsernameQuery(
                $this->getMasterFactory()->createProfileGateway()
            );
        }

        /**
         * @return \Ganked\Frontend\Queries\Social\FetchProfileForUsernameQuery
         */
        public function createFetchProfileForUsernameQuery()
        {
            return new \Ganked\Frontend\Queries\Social\FetchProfileForUsernameQuery(
                $this->getMasterFactory()->createGankedApiGateway()
            );
        }

        /**
         * @return \Ganked\Frontend\Queries\FetchRunesForSummonerQuery
         */
        public function createFetchRunesForSummonerQuery()
        {
            return new \Ganked\Frontend\Queries\FetchRunesForSummonerQuery(
                $this->getMasterFactory()->createLoLGateway()
            );
        }

        /**
         * @return \Ganked\Frontend\Queries\FetchMasteriesForSummonerQuery
         */
        public function createFetchMasteriesForSummonerQuery()
        {
            return new \Ganked\Frontend\Queries\FetchMasteriesForSummonerQuery(
                $this->getMasterFactory()->createLoLGateway()
            );
        }

        /**
         * @return \Ganked\Frontend\Queries\FetchMatchlistsForSummonersInRegionByUsernameQuery
         */
        public function createFetchMatchlistsForSummonersInRegionQuery()
        {
            return new \Ganked\Frontend\Queries\FetchMatchlistsForSummonersInRegionByUsernameQuery(
                $this->getMasterFactory()->createLoLGateway()
            );
        }

        /**
         * @return \Ganked\Frontend\Queries\SummonerMultiSearchQuery
         */
        public function createSummonerMultiSearchQuery()
        {
            return new \Ganked\Frontend\Queries\SummonerMultiSearchQuery(
                $this->getMasterFactory()->createLoLGateway()
            );
        }

        /**
         * @return \Ganked\Frontend\Queries\FetchSummonerCurrentGameQuery
         */
        public function createFetchSummonerCurrentGameQuery()
        {
            return new \Ganked\Frontend\Queries\FetchSummonerCurrentGameQuery(
                $this->getMasterFactory()->createLoLGateway()
            );
        }

        /**
         * @return \Ganked\Frontend\Queries\FetchRankedStatsForSummonerQuery
         */
        public function createFetchRankedStatsForSummonerQuery()
        {
            return new \Ganked\Frontend\Queries\FetchRankedStatsForSummonerQuery(
                $this->getMasterFactory()->createLoLGateway()
            );
        }

        /**
         * @return \Ganked\Frontend\Queries\FetchSummonerComparisonStatsQuery
         */
        public function createFetchSummonerComparisonStatsQuery()
        {
            return new \Ganked\Frontend\Queries\FetchSummonerComparisonStatsQuery(
                $this->getMasterFactory()->createLoLGateway()
            );
        }

        /**
         * @return \Ganked\Frontend\Queries\FetchDefaultLeagueOfLegendsRegionFromSessionQuery
         */
        public function createFetchDefaultLeagueOfLegendsRegionFromSessionQuery()
        {
            return new \Ganked\Frontend\Queries\FetchDefaultLeagueOfLegendsRegionFromSessionQuery(
                $this->getSessionData()
            );
        }

        /**
         * @return \Ganked\Frontend\Queries\HasDefaultLeagueOfLegendsRegionFromSessionQuery
         */
        public function createHasDefaultLeagueOfLegendsRegionFromSessionQuery()
        {
            return new \Ganked\Frontend\Queries\HasDefaultLeagueOfLegendsRegionFromSessionQuery(
                $this->getSessionData()
            );
        }

        /**
         * @return \Ganked\Frontend\Queries\HasUserFavouritedSummonerQuery
         */
        public function createHasUserFavouritedSummonerQuery()
        {
            return new \Ganked\Frontend\Queries\HasUserFavouritedSummonerQuery(
                $this->getMasterFactory()->createFavouritesGateway()
            );
        }

        /**
         * @return \Ganked\Frontend\Queries\FetchUserFavouriteSummonersQuery
         */
        public function createFetchUserFavouriteSummonersQuery()
        {
            return new \Ganked\Frontend\Queries\FetchUserFavouriteSummonersQuery(
                $this->getMasterFactory()->createFavouritesGateway()
            );
        }

        /**
         * @return \Ganked\Frontend\Queries\FetchPlayerBansQuery
         */
        public function createFetchPlayerBansQuery()
        {
            return new \Ganked\Frontend\Queries\FetchPlayerBansQuery(
                $this->getMasterFactory()->createSteamGateway()
            );
        }

        /**
         * @return \Ganked\Frontend\Queries\ResolveVanityUrlQuery
         */
        public function createResolveVanityUrlQuery()
        {
            return new \Ganked\Frontend\Queries\ResolveVanityUrlQuery(
                $this->getMasterFactory()->createSteamGateway()
            );
        }
    }
}
