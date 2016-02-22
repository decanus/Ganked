<?php

/**
 * Copyright (c) Ganked 2015
 * All rights reserved.
 */

namespace Ganked\Frontend\Models
{

    use Ganked\Frontend\DataObjects\Summoner;
    use Ganked\Skeleton\Models\AbstractPageModel;

    abstract class AbstractSummonerModel extends AbstractPageModel
    {

        /**
         * @var Summoner
         */
        private $summoner;

        /**
         * @var array
         */
        private $game = [];

        /**
         * @var bool
         */
        private $hasFavouritedSummoner = false;

        /**
         * @var array
         */
        private $entry = [];

        /**
         * @param Summoner $summoner
         */
        public function setSummoner(Summoner $summoner)
        {
            $this->summoner = $summoner;
        }

        /**
         * @return Summoner
         */
        public function getSummoner()
        {
            return $this->summoner;
        }

        /**
         * @param array $game
         */
        public function setCurrentGame($game = [])
        {
            $this->game = $game;
        }

        /**
         * @return array
         */
        public function getCurrentGame()
        {
            return $this->game;
        }

        /**
         * @param bool $hasFavouritedSummoner
         */
        public function setHasFavouritedSummoner($hasFavouritedSummoner)
        {
            $this->hasFavouritedSummoner = $hasFavouritedSummoner;
        }

        /**
         * @return bool
         */
        public function getHasFavouritedSummoner()
        {
            return $this->hasFavouritedSummoner;
        }

        /**
         * @param array $entry
         */
        public function setEntry(array $entry = [])
        {
            $this->entry = $entry;
        }

        /**
         * @return array
         */
        public function getEntry()
        {
            return $this->entry;
        }
    }
}
