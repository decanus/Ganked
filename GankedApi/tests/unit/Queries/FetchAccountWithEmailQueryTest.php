<?php
 /**
 * Copyright (c) Ganked 2015
 * All rights reserved.
 */
 
namespace Ganked\API\Queries
{
    use Ganked\Library\ValueObjects\Email;

    /**
     * @covers Ganked\API\Queries\FetchAccountWithEmailQuery
     */
    class FetchAccountWithEmailQueryTest extends \PHPUnit_Framework_TestCase
    {
        public function testExecuteWorks()
        {
            $userService = $this->getMockBuilder(\Ganked\API\Services\UserService::class)
                ->disableOriginalConstructor()
                ->getMock();

            $query = new FetchAccountWithEmailQuery($userService);
            $email = new Email('foo@bar.net');

            $userService->expects($this->once())->method('getAccountWithEmail')->with($email)->will($this->returnValue(['foo']));
            $this->assertSame(['foo'], $query->execute($email));
        }
    }
}
