<?php
 /**
 * Copyright (c) Ganked 2015
 * All rights reserved.
 */
 
namespace Ganked\Skeleton\Commands
{
    /**
     * @covers Ganked\Skeleton\Commands\DestroySessionCommand
     */
    class DestroySessionCommandTest extends \PHPUnit_Framework_TestCase
    {
        public function testSessionDestroyWorks()
        {
            $session = $this->getMockBuilder(\Ganked\Skeleton\Session\Session::class)
                ->disableOriginalConstructor()
                ->getMock();
            $request = $this->getMockBuilder(\Ganked\Skeleton\Http\Request\PostRequest::class)
                ->disableOriginalConstructor()
                ->getMock();
            $command = new DestroySessionCommand($session);

            $session->expects($this->once())->method('destroy')->with($request);
            $command->execute($request);
        }
    }
}
