<?php

/**
 * Copyright (c) Ganked 2015
 * All rights reserved.
 */
 
namespace Ganked\Library\DataPool
{
    use Ganked\Library\Helpers\DomHelper;
    use Ganked\Library\ValueObjects\DataVersion;
    use Ganked\Library\ValueObjects\MetaTags;

    /**
     * @covers Ganked\Library\DataPool\DataPoolReader
     * @covers \Ganked\Library\DataPool\AbstractDataPool
     * @uses \Ganked\Library\Helpers\DomHelper
     * @uses \Ganked\Library\ValueObjects\DataVersion
     */
    class DataPoolReaderTest extends \PHPUnit_Framework_TestCase
    {
        /**
         * @var DataPoolReader
         */
        private $dataPoolReader;
        private $redisBackend;

        protected function setUp()
        {
            $this->redisBackend = $this->getMockBuilder(\Ganked\Library\DataPool\RedisBackend::class)
                ->disableOriginalConstructor()
                ->getMock();

            $this->dataPoolReader = new DataPoolReader($this->redisBackend);
        }

        public function testHasStaticPageReturnsExpectedValue()
        {
            $path = '/foo';

            $dataVersion = new DataVersion('now');

            $this->redisBackend
                ->expects($this->once())
                ->method('get')
                ->with('currentDataVersion')
                ->will($this->returnValue((string) $dataVersion));

            $this->redisBackend
                ->expects($this->once())
                ->method('hHas')
                ->with((string) $dataVersion, 'sp_' . $path)
                ->will($this->returnValue(true));

            $this->assertTrue($this->dataPoolReader->hasStaticPage($path));
        }

        public function testGetStaticPageSnippetReturnsDomHelper()
        {
            $path = '/foo';


            $dataVersion = new DataVersion('now');

            $this->redisBackend
                ->expects($this->once())
                ->method('get')
                ->with('currentDataVersion')
                ->will($this->returnValue((string) $dataVersion));

            $this->redisBackend
                ->expects($this->once())
                ->method('hGet')
                ->with((string) $dataVersion, 'sp_' . $path)
                ->will($this->returnValue('<div />'));

            $this->assertInstanceOf(
                \Ganked\Library\Helpers\DomHelper::class,
                $this->dataPoolReader->getStaticPageSnippet($path)
            );
        }

        public function testGetMetaTagsForStaticPageReturnsExpectedValue()
        {
            $path = '/foo';

            $meta = new MetaTags;

            $dataVersion = new DataVersion('now');

            $this->redisBackend
                ->expects($this->once())
                ->method('get')
                ->with('currentDataVersion')
                ->will($this->returnValue((string) $dataVersion));

            $this->redisBackend
                ->expects($this->once())
                ->method('hGet')
                ->with((string) $dataVersion, 'meta_' . $path)
                ->will($this->returnValue(serialize($meta)));

            $this->assertEquals(
                $meta,
                $this->dataPoolReader->getMetaTagsForStaticPage($path)
            );
        }

        public function testGetRecentSummonersListReturnsExpectedValue()
        {
            $this->redisBackend
                ->expects($this->once())
                ->method('getList')
                ->with('lol:summoners:recent')
                ->will($this->returnValue([]));

            $this->assertSame(
                [],
                $this->dataPoolReader->getRecentSummonersList()
            );
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

        public function testGetAllChampionsReturnsExpectedValue()
        {
            $this->redisBackend
                ->expects($this->once())
                ->method('hGetAll')
                ->with('lol:champions:data')
                ->will($this->returnValue([]));

            $this->assertSame([], $this->dataPoolReader->getAllChampions());
        }

        public function testGetFreeChampionsListReturnsExpectedValue()
        {
            $list = ['foo', 'bar', 'baz'];

            $this->redisBackend
                ->expects($this->once())
                ->method('getList')
                ->with('lol:champions:free')
                ->will($this->returnValue($list));

            $this->assertSame($list, $this->dataPoolReader->getFreeChampionsList());
        }

        public function testGetCurrentLeagueOfLegendsPatchReturnsExpectedValue()
        {
            $this->redisBackend
                ->expects($this->once())
                ->method('get')
                ->with('lol:patch')
                ->will($this->returnValue('1234'));

            $this->assertSame('1234', $this->dataPoolReader->getCurrentLeagueOfLegendsPatch());
        }

        public function testGetBodyClassForStaticPageReturnsExpectedValue()
        {
            $path = '/foo';
            $dataVersion = new DataVersion('now');

            $this->redisBackend
                ->expects($this->once())
                ->method('get')
                ->with('currentDataVersion')
                ->will($this->returnValue((string) $dataVersion));

            $this->redisBackend
                ->expects($this->once())
                ->method('hGet')
                ->with((string) $dataVersion, 'bodyClass_' . $path)
                ->will($this->returnValue('foo'));

            $this->assertEquals(
                'foo',
                $this->dataPoolReader->getBodyClassForStaticPage($path)
            );
        }

        public function testGetInfoBarMessageReturnsExpectedValue()
        {

            $this->redisBackend
                ->expects($this->once())
                ->method('get')
                ->with('infoBarMessage')
                ->will($this->returnValue('1234'));

            $this->assertSame('1234', $this->dataPoolReader->getInfoBarMessage());
        }

        public function testIsInfoBarEnabledReturnsExpectedBool()
        {
            $this->redisBackend
                ->expects($this->once())
                ->method('get')
                ->with('infoBarEnabled')
                ->will($this->returnValue('true'));

            $this->assertTrue($this->dataPoolReader->isInfoBarEnabled());
        }

        public function testGetCounterStrikeAchievementsTemplateReturnsExpectedValue()
        {
            $this->redisBackend
                ->expects($this->once())
                ->method('get')
                ->with('csgo:achievements:template')
                ->will($this->returnValue('<div />'));

            $this->assertEquals(new DomHelper('<div />'), $this->dataPoolReader->getCounterStrikeAchievementsTemplate());
        }
    }
}
