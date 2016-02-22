<?php

/**
 * Copyright (c) Dean Eigenmann 2015
 * All rights reserved.
 */
 
namespace Ganked\Frontend\DataObjects\CounterStrike
{
    /**
     * @covers Ganked\Frontend\DataObjects\CounterStrike\User
     */
    class UserTest extends \PHPUnit_Framework_TestCase
    {
        /**
         * @var User
         */
        private $user;
        private $id;
        private $name;

        protected function setUp()
        {
            $this->id = '23';
            $this->name = 'babo mc';
            $this->user = new User($this->id, $this->name);
        }

        public function testGetIdWorks()
        {
            $this->assertSame($this->id, $this->user->getId());
        }

        public function testGetNameWorks()
        {
            $this->assertSame($this->name, $this->user->getName());
        }

        public function testSetAndGetAchievementsWorks()
        {
            $achievements = [];
            $this->user->setAchievements($achievements);
            $this->assertSame($achievements, $this->user->getAchievements());
        }

        public function testSetAndGetStatsWorks()
        {
            $stats = [];
            $this->user->setStats($stats);
            $this->assertSame($stats, $this->user->getStats());
        }

        public function testSetAndGetImageWorks()
        {
            $image = 'test.jpg';
            $this->user->setImage($image);
            $this->assertSame($image, $this->user->getImage());
        }

        public function testSetAndGetLastLogOffWorks()
        {
            $lastLogOff = new \DateTime;
            $this->user->setLastLogOff($lastLogOff);
            $this->assertSame($lastLogOff, $this->user->getLastLogOff());
        }

        public function testSetAndGetCurrentGameIdWorks()
        {
            $this->user->setCurrentGameId('123');
            $this->assertSame('123', $this->user->getCurrentGameId());
        }

        public function testSetAndGetStatusWorks()
        {
            $this->user->setStatus('foo');
            $this->assertSame('foo', $this->user->getStatus());
        }
    }
}
