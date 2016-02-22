<?php

/**
 * Copyright (c) Ganked 2015
 * All rights reserved.
 */
 
namespace Ganked\Frontend\Models
{

    use Ganked\Skeleton\Models\AbstractPageModel;

    class MatchPageModel extends AbstractPageModel
    {
        /**
         * @var array
         */
        private $match;

        /**
         * @param array $match
         */
        public function setMatchData(array $match)
        {
            $this->match = $match;
        }

        /**
         * @return array
         */
        public function getMatchData()
        {
            return $this->match;
        }
    }
}
