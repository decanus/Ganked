<?php
 /**
 * Copyright (c) Ganked 2015
 * All rights reserved.
 */
 
namespace Ganked\Post\Commands
{

    use Ganked\Library\ValueObjects\Email;

    class VerifyUserCommandTest extends \PHPUnit_Framework_TestCase
    {
        public function testExecuteWorks()
        {
            $accountGateway = $this->getMockBuilder(\Ganked\Skeleton\Gateways\AccountGateway::class)
                ->setMethods(['setUserVerified'])
                ->disableOriginalConstructor()
                ->getMock();

            $response = $this->getMockBuilder(\Ganked\Skeleton\Backends\Wrappers\CurlResponse::class)
                ->disableOriginalConstructor()
                ->getMock();

            $command = new VerifyUserCommand($accountGateway);

            $email = new Email('test@ganked.net');

            $accountGateway
                ->expects($this->once())
                ->method('setUserVerified')
                ->with((string) $email)
                ->will($this->returnValue($response));

            $response->expects($this->once())->method('getBody')->will($this->returnValue('[]'));

            $this->assertSame([], $command->execute($email));

        }
    }
}
