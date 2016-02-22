<?php
/**
 * Copyright (c) Ganked 2015
 * All rights reserved.
 */

namespace Ganked\Backend\Tasks
{

    use Ganked\Library\ValueObjects\Uri;

    /**
     * @covers Ganked\Backend\Tasks\LeagueOfLegendsRunesGetTask
     */
    class LeagueOfLegendsRunesGetTaskTest extends \PHPUnit_Framework_TestCase
    {
        /**
         * @var LeagueOfLegendsRunesGetTask
         */
        private $task;
        private $runesDownloadUri;
        private $curl;
        private $leagueOfLegendsDataPoolWriter;
        private $request;

        protected function setUp()
        {
            $this->runesDownloadUri = new Uri('foobar.net');
            $this->curl = $this->getMockBuilder(\Ganked\Library\Curl\Curl::class)
                ->disableOriginalConstructor()
                ->getMock();
            $this->leagueOfLegendsDataPoolWriter = $this->getMockBuilder(\Ganked\Library\DataPool\LeagueOfLegendsDataPoolWriter::class)
                ->disableOriginalConstructor()
                ->getMock();
            $this->request = $this->getMockBuilder(\Ganked\Backend\Request::class)
                ->disableOriginalConstructor()
                ->getMock();

            $this->task = new LeagueOfLegendsRunesGetTask(
                $this->runesDownloadUri,
                $this->curl,
                $this->leagueOfLegendsDataPoolWriter
            );

        }

        public function testRunWorks()
        {
            $curlResponse = $this->getMockBuilder(\Ganked\Library\Curl\Response::class)
                ->disableOriginalConstructor()
                ->getMock();

            $this->curl
                ->expects($this->once())
                ->method('get')
                ->with($this->runesDownloadUri)
                ->will($this->returnValue($curlResponse));

            $data = [
                'data' => [
                    'foo' => [],
                    'bar' => []
                ]
            ];

            $curlResponse->expects($this->once())->method('getDecodedJsonResponse')->will($this->returnValue($data));

            $this->leagueOfLegendsDataPoolWriter
                ->expects($this->at(0))
                ->method('setRune')
                ->with('foo', '[]');
            $this->leagueOfLegendsDataPoolWriter
                ->expects($this->at(1))
                ->method('setRune')
                ->with('bar', '[]');

            $this->task->run($this->request);
        }
    }
}
