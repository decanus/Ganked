<?php
 /**
 * Copyright (c) Ganked 2015
 * All rights reserved.
 */
 
namespace Ganked\Post\Commands
{

    use Ganked\Library\ValueObjects\Post;

    /**
     * @covers Ganked\Post\Commands\CreateNewPostCommand
     */
    class CreateNewPostCommandTest extends \PHPUnit_Framework_TestCase
    {
        public function testExecuteWorks()
        {
            $gateway = $this->getMockBuilder(\Ganked\Library\Gateways\GankedApiGateway::class)
                ->disableOriginalConstructor()
                ->getMock();

            $curlResponse = $this->getMockBuilder(\Ganked\Library\Curl\Response::class)
                ->disableOriginalConstructor()
                ->getMock();

            $post = new Post('bleg');

            $gateway
                ->expects($this->once())
                ->method('createNewPost')
                ->with($post)
                ->will($this->returnValue($curlResponse));

            $curlResponse->expects($this->once())->method('getDecodedJsonResponse')->will($this->returnValue([]));

            $command = new CreateNewPostCommand($gateway);
            $this->assertSame([], $command->execute($post));
        }
    }
}
