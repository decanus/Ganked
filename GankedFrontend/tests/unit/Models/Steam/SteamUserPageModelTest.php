<?php

/**
 * Copyright (c) Dean Eigenmann 2015
 * All rights reserved.
 */
 
namespace Ganked\Frontend\Models
{
    /**
     * @covers Ganked\Frontend\Models\SteamUserPageModel
     * @covers \Ganked\Skeleton\Models\AbstractPageModel
     * @covers \Ganked\Skeleton\Models\AbstractModel
     */
    class SteamUserPageModelTest extends \PHPUnit_Framework_TestCase
    {
        /**
         * @var SteamUserPageModel
         */
        private $model;
        private $user;
        private $uri;

        protected function setUp()
        {
            $this->uri = $this->getMockBuilder(\Ganked\Library\ValueObjects\Uri::class)
                ->disableOriginalConstructor()
                ->getMock();

            $this->user = $this->getMockBuilder(\Ganked\Frontend\DataObjects\CounterStrike\User::class)
                ->disableOriginalConstructor()
                ->getMock();
            $this->model = new SteamUserPageModel($this->uri);
        }

        public function testSetAndGetUserWorks()
        {
            $this->model->setUser($this->user);
            $this->assertSame($this->user, $this->model->getUser());
        }

        public function testSetAndGetBansWorks()
        {
            $bans = ['foo'];
            $this->model->setBans($bans);
            $this->assertSame($bans, $this->model->getBans());
        }
    }
}
