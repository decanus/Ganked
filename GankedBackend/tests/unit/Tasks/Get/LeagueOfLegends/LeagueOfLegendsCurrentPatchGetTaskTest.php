<?php

/**
 * Copyright (c) Ganked 2015
 * All rights reserved.
 */

namespace Ganked\Backend\Tasks
{

    use Ganked\Library\ValueObjects\Uri;

    /**
     * @covers Ganked\Backend\Tasks\LeagueOfLegendsCurrentPatchGetTask
     * @uses Ganked\Backend\Request
     */
    class LeagueOfLegendsCurrentPatchGetTaskTest extends \PHPUnit_Framework_TestCase
    {
        /**
         * @var LeagueOfLegendsCurrentPatchGetTask
         */
        private $task;
        private $curl;
        private $dataPoolReader;
        private $dataPoolWriter;
        private $leagueOfLegendsVersionListUri;
        private $taskLocator;
        private $request;

        protected function setUp()
        {
            $this->curl = $this->getMockBuilder(\Ganked\Library\Curl\Curl::class)
                ->disableOriginalConstructor()
                ->getMock();
            $this->dataPoolReader = $this->getMockBuilder(\Ganked\Library\DataPool\DataPoolReader::class)
                ->disableOriginalConstructor()
                ->getMock();
            $this->dataPoolWriter = $this->getMockBuilder(\Ganked\Library\DataPool\DataPoolWriter::class)
                ->disableOriginalConstructor()
                ->getMock();
            $this->leagueOfLegendsVersionListUri = new Uri('https://global.api.pvp.net/versions');
            $this->taskLocator = $this->getMockBuilder(\Ganked\Backend\Locators\TaskLocator::class)
                ->disableOriginalConstructor()
                ->getMock();
            $this->request = $this->getMockBuilder(\Ganked\Backend\Request::class)
                ->disableOriginalConstructor()
                ->getMock();

            $this->task = new LeagueOfLegendsCurrentPatchGetTask(
                $this->curl,
                $this->dataPoolReader,
                $this->dataPoolWriter,
                $this->leagueOfLegendsVersionListUri,
                $this->taskLocator
            );
        }

        public function testExecuteWorks()
        {
            $response = $this->getMockBuilder(\Ganked\Library\Curl\Response::class)
                ->disableOriginalConstructor()
                ->getMock();

            $this->curl
                ->expects($this->once())
                ->method('get')
                ->with($this->leagueOfLegendsVersionListUri)
                ->will($this->returnValue($response));

            $response->expects($this->once())->method('getDecodedJsonResponse')->will($this->returnValue(['123', '1234']));

            $this->dataPoolReader
                ->expects($this->once())
                ->method('getCurrentLeagueOfLegendsPatch')
                ->will($this->returnValue('1234'));

            $task = $this->getMockBuilder(\Ganked\Backend\Tasks\TaskInterface::class)
                ->disableOriginalConstructor()
                ->getMock();

            $this->taskLocator
                ->expects($this->exactly(5))
                ->method('locate')
                ->will($this->returnValue($task));

            $task->expects($this->exactly(5))->method('run');

            $this->task->run($this->request);
        }
    }
}
