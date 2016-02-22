<?php
/**
 * Copyright (c) Ganked 2015
 * All rights reserved.
 */

namespace Ganked\Frontend\Models
{

    /**
     * @covers Ganked\Frontend\Models\SummonerRunesPageModel
     * @covers \Ganked\Skeleton\Models\AbstractPageModel
     * @covers \Ganked\Skeleton\Models\AbstractModel
     * @covers \Ganked\Frontend\Models\AbstractSummonerModel
     */
    class SummonerRunesPageModelTest extends \PHPUnit_Framework_TestCase
    {
        /**
         * @var SummonerRunesPageModel
         */
        private $model;

        protected function setUp()
        {
            $uri = $this->getMockBuilder(\Ganked\Library\ValueObjects\Uri::class)
                ->disableOriginalConstructor()
                ->getMock();

            $this->model = new SummonerRunesPageModel($uri);
        }


        public function testSetAndGetRunesWorks()
        {
            $runes = ['foo' => 'bar'];

            $this->model->setRunes($runes);
            $this->assertSame($runes, $this->model->getRunes());
        }
    }
}
