<?php

/**
 * Copyright (c) Ganked 2015
 * All rights reserved.
 */

namespace Ganked\Frontend\Models
{

    use Ganked\Skeleton\Models\AbstractPageModel;

    class SummonerComparisonPageModel extends AbstractPageModel
    {
        /**
         * @var array
         */
        private $data;

        /**
         * @param array $data
         */
        public function setSummonerData(array $data = [])
        {
            $this->data = $data;
        }

        /**
         * @return array
         */
        public function getSummonerData()
        {
            return $this->data;
        }
    }
}
