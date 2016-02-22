<?php

/**
 * Copyright (c) Ganked 2015
 * All rights reserved.
 */
 
namespace Ganked\Frontend\Readers
{

    use Ganked\Library\ValueObjects\LeagueOfLegends\Region;
    use Ganked\Library\ValueObjects\LeagueOfLegends\SummonerName;
    use Ganked\Skeleton\Gateways\LoLGateway;

    class LeagueOfLegendsReader
    {
        /**
         * @var LoLGateway
         */
        private $loLGateway;

        /**
         * @param LoLGateway $loLGateway
         */
        public function __construct(LoLGateway $loLGateway)
        {
            $this->loLGateway = $loLGateway;
        }

        /**
         * @param Region       $region
         * @param SummonerName $name
         *
         * @return bool
         */
        public function hasSummonerForRegionWithName(Region $region, SummonerName $name)
        {
            return json_decode($this->loLGateway->getSummonerForRegionByName((string) $region, (string) $name)->getBody(), true) !== [];
        }

        /**
         * @param string $region
         * @param string $id
         *
         * @return bool
         */
        public function hasMatchForRegionById($region, $id)
        {
            return json_decode($this->loLGateway->getMatchForRegion($region, $id)->getBody(), true) !== [];
        }
    }
}
