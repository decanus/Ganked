<?php

/**
 * Copyright (c) Ganked 2015
 * All rights reserved.
 */
 
namespace Ganked\API\Commands
{
    /**
     * @covers Ganked\API\Commands\InsertUserCommand
     */
    class InsertUserCommandTest extends \PHPUnit_Framework_TestCase
    {
        public function testExecuteWorks()
        {
            $userService = $this->getMockBuilder(\Ganked\API\Services\UserService::class)
                ->disableOriginalConstructor()
                ->getMock();

            $command = new InsertUserCommand($userService);
            $user = ['foo' => 'bar'];

            $userService->expects($this->once())->method('createNewUser')->with($user)->will($this->returnValue($user));

            $this->assertSame($user, $command->execute($user));
        }
    }
}
