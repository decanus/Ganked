<?php
 /**
 * Copyright (c) Ganked 2015
 * All rights reserved.
 */
 
namespace Ganked\Post\Commands
{

    use Ganked\Library\ValueObjects\Email;
    use Ganked\Library\ValueObjects\UserId;
    use Ganked\Library\ValueObjects\Username;

    /**
     * @covers Ganked\Post\Commands\LoginUserCommand
     */
    class LoginUserCommandTest extends \PHPUnit_Framework_TestCase
    {
        public function testExecuteWorks()
        {
            $sessionData = $this->getMockBuilder(\Ganked\Skeleton\Session\SessionData::class)
                ->disableOriginalConstructor()
                ->getMock();

            $command = new LoginUserCommand($sessionData);

            $email = new Email('test@ganked.net');
            $username = new Username('lel');
            $id = new UserId;

            $sessionData
                ->expects($this->once())
                ->method('setAccount')
                ->with($this->isInstanceOf(\Ganked\Library\DataObjects\Accounts\RegisteredAccount::class));

            $command->execute($email, $username, (string) $id);
        }
    }
}
