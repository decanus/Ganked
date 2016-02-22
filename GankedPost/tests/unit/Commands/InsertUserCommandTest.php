<?php
 /**
 * Copyright (c) Ganked 2015
 * All rights reserved.
 */
 

namespace Ganked\Post\Commands
{

    use Ganked\Library\ValueObjects\Email;
    use Ganked\Library\ValueObjects\FirstName;
    use Ganked\Library\ValueObjects\Hash;
    use Ganked\Library\ValueObjects\LastName;
    use Ganked\Library\ValueObjects\Salt;
    use Ganked\Library\ValueObjects\Username;

    /**
     * @covers Ganked\Post\Commands\InsertUserCommand
     */
    class InsertUserCommandTest extends \PHPUnit_Framework_TestCase
    {
        public function testExecuteWorks()
        {
            $accountGateway = $this->getMockBuilder(\Ganked\Library\Gateways\GankedApiGateway::class)
                ->setMethods(['createNewUser'])
                ->disableOriginalConstructor()
                ->getMock();
            $command = new InsertUserCommand($accountGateway);

            $firstName = new FirstName('hans');
            $lastName = new LastName('müller');
            $username = new Username('lel');
            $hash = new Hash('123', '2');
            $salt = new Salt();
            $email = new Email('test@ganked.net');
            $verificationHash = '1234';

            $user = [
                'firstname' => (string) $firstName,
                'lastname' => (string) $lastName,
                'username' => (string) $username,
                'password' => (string) $hash,
                'salt' => (string) $salt,
                'email' => (string) $email,
                'hash' => $verificationHash,
            ];

            $accountGateway->expects($this->once())->method('createNewUser')->with($user);
            $command->execute($firstName, $lastName, $username, $hash, $salt, $email, $verificationHash);
        }
    }
}
