<?php
 /**
 * Copyright (c) Ganked 2015
 * All rights reserved.
 */

namespace Ganked\Skeleton\Commands
{
    /**
     * @covers Ganked\Skeleton\Commands\WriteSessionCommand
     */
    class WriteSessionCommandTest extends \PHPUnit_Framework_TestCase
    {
        public function testSessionWriteWorks()
        {
            $session = $this->getMockBuilder(\Ganked\Skeleton\Session\Session::class)
                ->disableOriginalConstructor()
                ->getMock();
            $command = new WriteSessionCommand($session);

            $session->expects($this->once())->method('write');
            $command->execute();
        }
    }
}
