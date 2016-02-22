<?php
 /**
 * Copyright (c) Ganked 2015
 * All rights reserved.
 */
 
namespace Ganked\API\Queries
{
    use Ganked\Library\ValueObjects\Username;

    /**
     * @covers Ganked\API\Queries\GetUserFromDatabaseQuery
     */
    class GetUserFromDatabaseQueryTest extends \PHPUnit_Framework_TestCase
    {
        public function testExecuteWorks()
        {
            $userService = $this->getMockBuilder(\Ganked\API\Services\UserService::class)
                ->disableOriginalConstructor()
                ->getMock();

            $query = new GetUserFromDatabaseQuery($userService);
            $username = new Username('foobar');

            $userService->expects($this->once())->method('getUserByUsername')->with($username, [])->will($this->returnValue(['foo']));
            $this->assertSame(['foo'], $query->execute($username));
        }
    }
}
