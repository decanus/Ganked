<?php

/**
 * Copyright (c) Ganked 2015
 * All rights reserved.
 */

namespace Ganked\Frontend\Models
{

    class SummonerChampionsPageModel extends AbstractSummonerModel
    {
        /**
         * @var array
         */
        private $stats;

        /**
         * @param array $stats
         */
        public function setStats(array $stats)
        {
            $this->stats = $stats;
        }

        /**
         * @return array
         */
        public function getStats()
        {
            return $this->stats;
        }

    }
}
