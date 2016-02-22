<?php

/**
 * Copyright (c) Dean Eigenmann 2015
 * All rights reserved.
 */
 
namespace Ganked\Frontend\Models
{
    class SummonerPageModel extends AbstractSummonerModel
    {
        /**
         * @var array
         */
        private $recentMatches;

        /**
         * @param array $recentMatches
         */
        public function setRecentMatches(array $recentMatches)
        {
            $this->recentMatches = $recentMatches;
        }

        /**
         * @return array
         */
        public function getRecentMatches()
        {
            return $this->recentMatches;
        }
    }
}
