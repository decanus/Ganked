<?php

/**
 * Copyright (c) Ganked 2015
 * All rights reserved.
 */
 
namespace Ganked\Backend\Mappers
{
    class LeagueOfLegendsLeaderboardMapper
    {
        /**
         * @param string $region
         * @param string $tier
         * @param array  $leaderboard
         *
         * @return array
         */
        public function map($region, $tier, array $leaderboard)
        {
            $date = (new \DateTime)->format('Ymd');

            $leaderboard = $leaderboard['entries'];

            foreach ($leaderboard as $key => $entry) {
                $entry['tier'] = $tier;
                $entry['region'] = $region;
                $entry['date'] = $date;

                $leaderboard[$key] = $entry;
            }

            return $leaderboard;
        }
    }
}
