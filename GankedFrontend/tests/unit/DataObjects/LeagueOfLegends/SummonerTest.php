<?php

/**
 * Copyright (c) Dean Eigenmann 2015
 * All rights reserved.
 */
 
namespace Ganked\Frontend\DataObjects
{

    use Ganked\Library\ValueObjects\LeagueOfLegends\Region;

    /**
     * @covers Ganked\Frontend\DataObjects\Summoner
     */
    class SummonerTest extends \PHPUnit_Framework_TestCase
    {
        /**
         * @var Summoner
         */
        private $summoner;
        private $id;
        private $icon;
        private $name;
        private $level;
        private $region;
        private $ttl;

        protected function setUp()
        {
            $this->id = 123;
            $this->icon = 123;
            $this->name = 'boss';
            $this->level = 300;
            $this->ttl = 100;
            $this->region = new Region('euw');

            $this->summoner = new Summoner($this->id, $this->name, $this->level, $this->icon, $this->region, $this->ttl);
        }

        public function testGetTTLWorks()
        {
            $this->assertSame($this->ttl, $this->summoner->getTTL());
        }

        public function testGetIdWorks()
        {
            $this->assertSame($this->id, $this->summoner->getId());
        }

        public function testGetNameWorks()
        {
            $this->assertSame($this->name, $this->summoner->getName());
        }

        public function testGetLevelWorks()
        {
            $this->assertSame($this->level, $this->summoner->getLevel());
        }

        public function testGetRegionWorks()
        {
            $this->assertSame($this->region, $this->summoner->getRegion());
        }

        public function testGetIconIdWorks()
        {
            $this->assertSame($this->icon, $this->summoner->getIconId());
        }
    }
}
