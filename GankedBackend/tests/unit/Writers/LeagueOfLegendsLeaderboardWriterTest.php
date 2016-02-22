<?php

/**
 * Copyright (c) Ganked 2015
 * All rights reserved.
 */
 
namespace Ganked\Backend\Writers
{

    /**
     * @covers Ganked\Backend\Writers\LeagueOfLegendsLeaderboardWriter
     */
    class LeagueOfLegendsLeaderboardWriterTest extends \PHPUnit_Framework_TestCase
    {
        public function testWriteWorks()
        {
            $mongo = $this->getMockBuilder(\Ganked\Library\Backends\MongoDatabaseBackend::class)
                ->disableOriginalConstructor()
                ->getMock();

            $writer = new LeagueOfLegendsLeaderboardWriter($mongo);

            $entries = [['foo' => 'bar'], ['baz' => 'qux']];
            $mongo->expects($this->once())->method('batchInsertIntoCollection')->with($entries, 'leaderboards');
            $writer->write($entries);
        }
    }
}
