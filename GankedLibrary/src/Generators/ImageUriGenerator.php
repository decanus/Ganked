<?php

/**
 * Copyright (c) Ganked 2015
 * All rights reserved.
 */

namespace Ganked\Library\Generators
{

    class ImageUriGenerator
    {
        /**
         * @param string $championId
         *
         * @return string
         */
        public function createChampionIconUri($championId)
        {
            return '//cdn.ganked.net/images/lol/champion/icon/' . $championId . '.png';
        }

        /**
         * @param string $imageFile
         *
         * @return string
         */
        public function createLeagueOfLegendsItemIconUri($imageFile)
        {
            return '//cdn.ganked.net/images/lol/item/' . $imageFile;
        }

        /**
         * @param string $imageFile
         *
         * @return string
         */
        public function createLeagueOfLegendsSpellIconUri($imageFile)
        {
            return '//cdn.ganked.net/images/lol/spell/' . $imageFile;
        }

        /**
         * @param string $imageFile
         *
         * @return string
         */
        public function createLeagueOfLegendsRuneIconUri($imageFile)
        {
            return '//cdn.ganked.net/images/lol/rune/' . $imageFile;
        }

        /**
         * @param string $imageId
         *
         * @return string
         */
        public function createSummonerProfileIconUri($imageId)
        {
            if ($imageId > 28 && 500 > $imageId) {
                $imageId = 0;
            }

            return '//cdn.ganked.net/images/lol/profileicon/' . $imageId . '.png';
        }

        /**
         * @param string $achievementName
         * @return string
         */
        public function createCounterStrikeAchievementIconUri($achievementName)
        {
            return '//cdn.ganked.net/images/csgo/achievements/' . strtolower($achievementName) . '.jpg';
        }

        /**
         * @param string $achievementName
         * @return string
         */
        public function createBlackAndWhiteCounterStrikeAchievementIconUri($achievementName)
        {
            return '//cdn.ganked.net/images/csgo/achievements/bw/' . strtolower($achievementName) . '.jpg';
        }
    }
}
