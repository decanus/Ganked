<?php
 /**
 * Copyright (c) Ganked 2015
 * All rights reserved.
 */
 
namespace Ganked\Skeleton\Commands
{
    /**
     * @covers Ganked\Skeleton\Commands\RemoveUserFromSessionCommand
     */
    class RemoveUserFromSessionCommandTest extends \PHPUnit_Framework_TestCase
    {
        public function testSessionDestroyWorks()
        {
            $sessionData = $this->getMockBuilder(\Ganked\Skeleton\Session\SessionData::class)
                ->disableOriginalConstructor()
                ->getMock();

            $command = new RemoveUserFromSessionCommand($sessionData);

            $sessionData->expects($this->once())->method('removeAccount');
            $command->execute();
        }
    }
}
