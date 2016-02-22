<?php

/**
 * Copyright (c) Ganked 2015
 * All rights reserved.
 */
 
namespace Ganked\Library\ValueObjects\LeagueOfLegends
{
    /**
     * @covers Ganked\Library\ValueObjects\LeagueOfLegends\SummonerName
     */
    class SummonerNameTest extends  \PHPUnit_Framework_TestCase
    {
        /**
         * @expectedException \InvalidArgumentException
         */
        public function testInvalidNameThrowsException()
        {
            new SummonerName('<?123ddddasddadsdsfasfafrafa');
        }

        public function testWorksWithValidName()
        {
            $summonerName = new SummonerName('foo bar');
            $this->assertSame('foobar', $summonerName->getSummonerNameForLink());
            $this->assertSame('foo bar', (string) $summonerName);
        }
    }
}
