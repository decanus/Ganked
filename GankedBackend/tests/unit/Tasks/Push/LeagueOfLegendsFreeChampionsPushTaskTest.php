<?php

/**
 * Copyright (c) Ganked 2015
 * All rights reserved.
 */

namespace Ganked\Backend\Tasks
{

    /**
     * @covers Ganked\Backend\Tasks\LeagueOfLegendsFreeChampionsPushTask
     */
    class LeagueOfLegendsFreeChampionsPushTaskTest extends \PHPUnit_Framework_TestCase
    {
        public function testExecuteWorks()
        {
            $gateway = $this->getMockBuilder(\Ganked\Skeleton\Gateways\LoLGateway::class)
                ->setMethods(['getFreeChampions'])
                ->disableOriginalConstructor()
                ->getMock();

            $dataPoolWriter = $this->getMockBuilder(\Ganked\Library\DataPool\DataPoolWriter::class)
                ->disableOriginalConstructor()
                ->getMock();

            $request = $this->getMockBuilder(\Ganked\Backend\Request::class)
                ->disableOriginalConstructor()
                ->getMock();

            $task = new LeagueOfLegendsFreeChampionsPushTask($gateway, $dataPoolWriter);

            $gatewayReturn = ['champions' => [['id' => '123'], ['id' => '332']]];

            $curlResponse = $this->getMockBuilder(\Ganked\Skeleton\Backends\Wrappers\CurlResponse::class)
                ->disableOriginalConstructor()
                ->getMock();

            $gateway->expects($this->once())->method('getFreeChampions')->will($this->returnValue($curlResponse));
            $curlResponse->expects($this->once())->method('getBody')->will($this->returnValue(json_encode($gatewayReturn)));

            $dataPoolWriter->expects($this->once())->method('setFreeChampions')->with(['123', '332']);

            $task->run($request);

        }
    }
}
