<?php

/**
 * Copyright (c) Dean Eigenmann 2015
 * All rights reserved.
 */
 
namespace Ganked\Frontend\DataObjects
{

    use Ganked\Library\ValueObjects\LeagueOfLegends\Region;

    class Summoner
    {
        /**
         * @var int
         */
        private $id;

        /**
         * @var string
         */
        private $name;

        /**
         * @var int
         */
        private $level;

        /**
         * @var int
         */
        private $iconId;

        /**
         * @var Region
         */
        private $region;

        /**
         * @var int
         */
        private $ttl;

        /**
         * @param int    $id
         * @param string $name
         * @param int    $level
         * @param int    $iconId
         * @param Region $region
         * @param int    $ttl
         */
        public function __construct($id, $name, $level, $iconId, Region $region, $ttl)
        {
            $this->id = $id;
            $this->name = $name;
            $this->level = $level;
            $this->iconId = $iconId;
            $this->region = $region;
            $this->ttl = $ttl;
        }

        /**
         * @return int
         */
        public function getId()
        {
            return $this->id;
        }

        /**
         * @return string
         */
        public function getName()
        {
            return $this->name;
        }

        /**
         * @return int
         */
        public function getLevel()
        {
            return $this->level;
        }

        /**
         * @return int
         */
        public function getIconId()
        {
            return $this->iconId;
        }

        /**
         * @return Region
         */
        public function getRegion()
        {
            return $this->region;
        }

        /**
         * @return int
         */
        public function getTTL()
        {
            return $this->ttl;
        }
    }
}
