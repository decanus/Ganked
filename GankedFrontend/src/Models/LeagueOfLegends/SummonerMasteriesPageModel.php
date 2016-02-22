<?php

/**
 * Copyright (c) Dean Eigenmann 2015
 * All rights reserved.
 */
 
namespace Ganked\Frontend\Models
{

    class SummonerMasteriesPageModel extends AbstractSummonerModel
    {
        /**
         * @var array
         */
        private $masteries;

        /**
         * @param array $masteries
         */
        public function setMasteries(array $masteries)
        {
            $this->masteries = $masteries;
        }

        /**
         * @return array
         */
        public function getMasteries()
        {
            return $this->masteries;
        }
    }
}
