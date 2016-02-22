<?php
 /**
 * Copyright (c) Ganked 2015
 * All rights reserved.
 */
 
namespace Ganked\API\Queries
{
    /**
     * @covers Ganked\API\Queries\HasUserByIdQuery
     */
    class HasUserByIdQueryTest extends \PHPUnit_Framework_TestCase
    {
        public function testExecuteWorks()
        {
            $userService = $this->getMockBuilder(\Ganked\API\Services\UserService::class)
                ->disableOriginalConstructor()
                ->getMock();

            $query = new HasUserByIdQuery($userService);
            $id = new \MongoId;

            $userService->expects($this->once())->method('getUserById')->with($id)->will($this->returnValue(['foo']));
            $this->assertTrue($query->execute($id));
        }
    }
}
