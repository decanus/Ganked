<?php
/**
 * Copyright (c) Ganked 2015
 * All rights reserved.
 */

namespace Ganked\Frontend\Models
{

    /**
     * @covers Ganked\Frontend\Models\SummonerMasteriesPageModel
     * @covers \Ganked\Skeleton\Models\AbstractPageModel
     * @covers \Ganked\Skeleton\Models\AbstractModel
     * @covers \Ganked\Frontend\Models\AbstractSummonerModel
     */
    class SummonerMasteriesPageModelTest extends \PHPUnit_Framework_TestCase
    {
        /**
         * @var SummonerMasteriesPageModel
         */
        private $model;

        protected function setUp()
        {
            $uri = $this->getMockBuilder(\Ganked\Library\ValueObjects\Uri::class)
                ->disableOriginalConstructor()
                ->getMock();

            $this->model = new SummonerMasteriesPageModel($uri);
        }


        public function testSetAndGetMasteriesWorks()
        {
            $masteries = ['foo' => 'bar'];

            $this->model->setMasteries($masteries);
            $this->assertSame($masteries, $this->model->getMasteries());
        }
    }
}
