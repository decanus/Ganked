<?php

/**
 * Copyright (c) Ganked 2015
 * All rights reserved.
 */

namespace Ganked\Library\DataPool
{

    use Ganked\Library\Helpers\DomHelper;

    /**
     * @covers Ganked\Library\DataPool\LeagueOfLegendsDataPoolReader
     * @covers \Ganked\Library\DataPool\AbstractDataPool
     * @uses \Ganked\Library\Helpers\DomHelper
     */
    class LeagueOfLegendsDataPoolReaderTest extends \PHPUnit_Framework_TestCase
    {
        /**
         * @var LeagueOfLegendsDataPoolReader
         */
        private $dataPoolReader;
        private $redisBackend;

        protected function setUp()
        {
            $this->redisBackend = $this->getMockBuilder(\Ganked\Library\DataPool\RedisBackend::class)
                ->disableOriginalConstructor()
                ->getMock();

            $this->dataPoolReader = new LeagueOfLegendsDataPoolReader($this->redisBackend);
        }

        public function testHasRuneReturnsExpectedBool()
        {
            $this->redisBackend
                ->expects($this->once())
                ->method('hHas')
                ->with('lol:runes', 'foo')
                ->will($this->returnValue(true));

            $this->assertTrue($this->dataPoolReader->hasRune('foo'));
        }


        public function testHasItemReturnsExpectedBool()
        {
            $this->redisBackend
                ->expects($this->once())
                ->method('hHas')
                ->with('lol:items', 'foo')
                ->will($this->returnValue(true));

            $this->assertTrue($this->dataPoolReader->hasItem('foo'));
        }

        /**
         * @expectedException \InvalidArgumentException
         */
        public function testGetRuneThrowsExceptionWhenRuneDoesNotExist()
        {
            $this->redisBackend
                ->expects($this->once())
                ->method('hHas')
                ->with('lol:runes', 'foo')
                ->will($this->returnValue(false));

            $this->dataPoolReader->getRune('foo');
        }

        /**
         * @expectedException \InvalidArgumentException
         */
        public function testGetItemThrowsExceptionWhenRuneDoesNotExist()
        {
            $this->redisBackend
                ->expects($this->once())
                ->method('hHas')
                ->with('lol:items', 'foo')
                ->will($this->returnValue(false));

            $this->dataPoolReader->getItem('foo');
        }

        public function testGetRuneReturnsExpectedValue()
        {
            $this->redisBackend
                ->expects($this->once())
                ->method('hHas')
                ->with('lol:runes', 'foo')
                ->will($this->returnValue(true));

            $this->redisBackend
                ->expects($this->once())
                ->method('hGet')
                ->with('lol:runes', 'foo')
                ->will($this->returnValue('{"foo":"bar"}'));

            $this->assertSame(['foo' => 'bar'], $this->dataPoolReader->getRune('foo'));
        }

        public function testGetItemReturnsExpectedValue()
        {
            $this->redisBackend
                ->expects($this->once())
                ->method('hHas')
                ->with('lol:items', 'foo')
                ->will($this->returnValue(true));

            $this->redisBackend
                ->expects($this->once())
                ->method('hGet')
                ->with('lol:items', 'foo')
                ->will($this->returnValue('{"foo":"bar"}'));

            $this->assertSame(['foo' => 'bar'], $this->dataPoolReader->getItem('foo'));
        }

        /**
         * @expectedException \OutOfBoundsException
         */
        public function testGetChampionByNameThrowsExceptionWhenChampionNotFound()
        {
            $name = 'jayce';

            $this->redisBackend
                ->expects($this->once())
                ->method('hHas')
                ->with('lol:champions:data', $name)
                ->will($this->returnValue(false));

            $this->assertTrue($this->dataPoolReader->getChampionByName($name));
        }

        public function testGetChampionByNameReturnsExpectedValue()
        {
            $name = 'jayce';

            $this->redisBackend
                ->expects($this->once())
                ->method('hHas')
                ->with('lol:champions:data', $name)
                ->will($this->returnValue(true));

            $this->redisBackend
                ->expects($this->once())
                ->method('hGet')
                ->with('lol:champions:data', $name)
                ->will($this->returnValue('{"foo": "bar"}'));

            $this->assertSame([ "foo" => "bar" ], $this->dataPoolReader->getChampionByName($name));
        }

        public function testGetLeagueOfLegendsMasteriesTemplateReturnsExpectedValue()
        {
            $this->redisBackend
                ->expects($this->once())
                ->method('get')
                ->with('lol:masteries:template')
                ->will($this->returnValue('<div />'));

            $this->assertEquals(new DomHelper('<div />'), $this->dataPoolReader->getLeagueOfLegendsMasteriesTemplate());
        }

        public function testHasChampionByIdReturnsExpectedValue()
        {
            $id = '123';

            $this->redisBackend
                ->expects($this->once())
                ->method('hHas')
                ->with('lol:champions:list', $id)
                ->will($this->returnValue(true));

            $this->assertTrue($this->dataPoolReader->hasChampionById($id));
        }

        /**
         * @expectedException \OutOfBoundsException
         */
        public function testGetChampionByIdThrowsExceptionWhenChampionNotFound()
        {
            $id = '123';

            $this->redisBackend
                ->expects($this->once())
                ->method('hHas')
                ->with('lol:champions:list', $id)
                ->will($this->returnValue(false));

            $this->assertTrue($this->dataPoolReader->getChampionById($id));
        }

        public function testGetChampionByIdReturnsExpectedValue()
        {
            $id = '123';

            $this->redisBackend
                ->expects($this->once())
                ->method('hHas')
                ->with('lol:champions:list', $id)
                ->will($this->returnValue(true));

            $this->redisBackend
                ->expects($this->once())
                ->method('hGet')
                ->with('lol:champions:list', $id)
                ->will($this->returnValue('foobar'));

            $this->assertSame('foobar', $this->dataPoolReader->getChampionById($id));
        }
    }
}
