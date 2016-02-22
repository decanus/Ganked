<?php
 /**
 * Copyright (c) Ganked 2015
 * All rights reserved.
 */
 
namespace Ganked\API\Queries
{
    use Ganked\Library\ValueObjects\Username;

    /**
     * @covers Ganked\API\Queries\FetchAccountWithUsernameQuery
     */
    class FetchAccountWithUsernameQueryTest extends \PHPUnit_Framework_TestCase
    {
        public function testExecuteWorks()
        {
            $userService = $this->getMockBuilder(\Ganked\API\Services\UserService::class)
                ->disableOriginalConstructor()
                ->getMock();

            $query = new FetchAccountWithUsernameQuery($userService);
            $username = new Username('foo');

            $userService->expects($this->once())->method('getAccountWithUsername')->with($username)->will($this->returnValue(['foo']));
            $this->assertSame(['foo'], $query->execute($username));
        }
    }
}
