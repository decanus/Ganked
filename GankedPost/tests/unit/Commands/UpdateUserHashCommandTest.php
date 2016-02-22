<?php
 /**
 * Copyright (c) Ganked 2015
 * All rights reserved.
 */
 
namespace Ganked\Post\Commands
{

    use Ganked\Library\ValueObjects\Email;

    /**
     * @covers Ganked\Post\Commands\UpdateUserHashCommand
     */
    class UpdateUserHashCommandTest extends \PHPUnit_Framework_TestCase
    {
        public function testExecuteWorks()
        {
            $accountGateway = $this->getMockBuilder(\Ganked\Skeleton\Gateways\AccountGateway::class)
                ->setMethods(['setUserHash'])
                ->disableOriginalConstructor()
                ->getMock();

            $query = new UpdateUserHashCommand($accountGateway);
            $email = new Email('test@ganked.net');
            $hash = '123';

            $accountGateway->expects($this->once())->method('setUserHash')->with((string) $email, $hash);
            $query->execute($email, $hash);
        }
    }
}
