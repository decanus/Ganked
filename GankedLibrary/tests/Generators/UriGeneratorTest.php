<?php
/**
 * Copyright (c) Ganked 2015
 * All rights reserved.
 */

namespace Ganked\Library\Generators
{

    use Ganked\Library\ValueObjects\LeagueOfLegends\Region;
    use Ganked\Library\ValueObjects\LeagueOfLegends\SummonerName;

    /**
     * @covers Ganked\Library\Generators\UriGenerator
     * @uses Ganked\Library\ValueObjects\LeagueOfLegends\Region
     * @uses Ganked\Library\ValueObjects\LeagueOfLegends\SummonerName
     */
    class UriGeneratorTest extends \PHPUnit_Framework_TestCase
    {
        /**
         * @var UriGenerator
         */
        private $uriBuilder;

        protected function setUp()
        {
            $this->uriBuilder = new UriGenerator;
        }

        public function testCreateSummonerUriReturnsExpectedValue()
        {
            $this->assertSame(
                '/games/lol/summoners/euw/foo',
                $this->uriBuilder->createSummonerUri(new Region('euw'), new SummonerName('foo'))
            );
        }

        public function testCreateChampionPageUriWorks()
        {
            $this->assertSame('/games/lol/champions/foo', $this->uriBuilder->createChampionPageUri('foo'));
        }

        public function testCreateMatchPageUriWorks()
        {
            $this->assertSame('/games/lol/matches/euw/foo', $this->uriBuilder->createMatchPageUri(new Region('euw'), 'foo'));
        }
    }
}
