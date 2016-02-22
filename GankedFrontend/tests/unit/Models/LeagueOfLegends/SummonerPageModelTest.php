<?php

/**
 * Copyright (c) Dean Eigenmann 2015
 * All rights reserved.
 */
 
namespace Ganked\Frontend\Models
{
    /**
     * @covers Ganked\Frontend\Models\SummonerPageModel
     * @covers \Ganked\Skeleton\Models\AbstractPageModel
     * @covers \Ganked\Skeleton\Models\AbstractModel
     * @covers \Ganked\Frontend\Models\AbstractSummonerModel
     */
    class SummonerPageModelTest extends \PHPUnit_Framework_TestCase
    {
        /**
         * @var SummonerPageModel
         */
        private $model;

        protected function setUp()
        {
            $uri = $this->getMockBuilder(\Ganked\Library\ValueObjects\Uri::class)
                ->disableOriginalConstructor()
                ->getMock();

            $this->model = new SummonerPageModel($uri);
        }

        public function testSetAndGetSummonerWorks()
        {
            $summoner = $this->getMockBuilder(\Ganked\Frontend\DataObjects\Summoner::class)
                ->disableOriginalConstructor()
                ->getMock();
            $this->model->setSummoner($summoner);

            $this->assertSame($summoner, $this->model->getSummoner());
        }


        public function testSetAndGetRecentMatchesWorks()
        {
            $matches = ['matches'];
            $this->model->setRecentMatches($matches);
            $this->assertSame($matches, $this->model->getRecentMatches());
        }

        public function testSetAndGetGameWorks()
        {
            $game = ['foo' => 'bar'];

            $this->model->setCurrentGame($game);
            $this->assertSame($game, $this->model->getCurrentGame());
        }
    }
}
