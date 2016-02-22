<?php

/**
 * Copyright (c) Ganked 2015
 * All rights reserved.
 */
 
namespace Ganked\Library\ValueObjects\LeagueOfLegends
{
    class Region 
    {
        /**
         * @var array
         */
        private $regions = ['br', 'eune', 'euw', 'kr', 'lan', 'las', 'na', 'oce', 'ru', 'tr'];

        /**
         * @var string
         */
        private $region;

        /**
         * @param string $region
         *
         * @throws \InvalidArgumentException
         */
        public function __construct($region)
        {
            $region = strtolower($region);
            if (!in_array($region, $this->regions)) {
                throw new \InvalidArgumentException('Region "' . $region . '" is not valid');
            }

            $this->region = $region;
        }

        public function __toString()
        {
            return $this->region;
        }
    }
}
