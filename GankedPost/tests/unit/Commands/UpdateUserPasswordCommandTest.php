<?php
 /**
 * Copyright (c) Ganked 2015
 * All rights reserved.
 */
 
namespace Ganked\Post\Commands
{

    use Ganked\Library\ValueObjects\Email;
    use Ganked\Library\ValueObjects\Hash;

    /**
     * @covers Ganked\Post\Commands\UpdateUserPasswordCommand
     */
    class UpdateUserPasswordCommandTest extends \PHPUnit_Framework_TestCase
    {
        public function testExecuteWorks()
        {
            $accountGateway = $this->getMockBuilder(\Ganked\Skeleton\Gateways\AccountGateway::class)
                ->setMethods(['updateUserPassword'])
                ->disableOriginalConstructor()
                ->getMock();

            $command = new UpdateUserPasswordCommand($accountGateway);

            $hash = new Hash('2', '1');
            $email = new Email('test@ganked.net');

            $accountGateway->expects($this->once())->method('updateUserPassword')->with((string) $hash, (string) $email);
            $command->execute($hash, $email);
        }
    }
}
