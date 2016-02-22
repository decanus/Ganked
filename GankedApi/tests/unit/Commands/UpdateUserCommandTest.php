<?php

/**
 * Copyright (c) Ganked 2015
 * All rights reserved.
 */
 
namespace Ganked\API\Commands
{
    /**
     * @covers Ganked\API\Commands\UpdateUserCommand
     */
    class UpdateUserCommandTest extends \PHPUnit_Framework_TestCase
    {
        public function testExecuteWorks()
        {
            $userService = $this->getMockBuilder(\Ganked\API\Services\UserService::class)
                ->disableOriginalConstructor()
                ->getMock();

            $command = new UpdateUserCommand($userService);
            $user = ['foo' => 'bar'];
            $id = new \MongoId;

            $userService->expects($this->once())->method('updateUser')->with($id, $user)->will($this->returnValue(true));

            $this->assertTrue($command->execute($id, $user));
        }
    }
}
