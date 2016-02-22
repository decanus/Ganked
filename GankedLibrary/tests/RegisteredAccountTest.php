<?php

/**
 * Copyright (c) Ganked 2015
 * All rights reserved.
 */

namespace Ganked\Library\DataObjects\Accounts
{

    use Ganked\Library\ValueObjects\Email;
    use Ganked\Library\ValueObjects\UserId;
    use Ganked\Library\ValueObjects\Username;

    /**
     * @covers Ganked\Library\DataObjects\Accounts\RegisteredAccount
     * @uses Ganked\Library\ValueObjects\Email
     * @uses Ganked\Library\ValueObjects\Username
     */
    class RegisteredAccountTest extends \PHPUnit_Framework_TestCase
    {
        /**
         * @var RegisteredAccount
         */
        private $account;
        private $id;
        private $email;
        private $username;

        protected function setUp()
        {
            $this->id = $this->getMockBuilder(\Ganked\Library\ValueObjects\UserId::class)
                ->disableOriginalConstructor()
                ->getMock();
            $this->email = $this->getMockBuilder(\Ganked\Library\ValueObjects\Email::class)
                ->disableOriginalConstructor()
                ->getMock();
            $this->username = $this->getMockBuilder(\Ganked\Library\ValueObjects\Username::class)
                ->disableOriginalConstructor()
                ->getMock();

            $this->account = new RegisteredAccount($this->id, $this->email, $this->username);
        }

        public function testGetIdReturnsExpectedValue()
        {
            $this->assertSame($this->id, $this->account->getId());
        }

        public function testGetEmailReturnsExpectedValue()
        {
            $this->assertSame($this->email, $this->account->getEmail());
        }

        public function testGetUsernameReturnsExpectedValue()
        {
            $this->assertSame($this->username, $this->account->getUsername());
        }

        public function testJsonEncodeWorks()
        {
            $userId = new UserId;
            $email = new Email('foo@bar.net');
            $username = new Username('foobar');

            $account = new RegisteredAccount($userId, $email, $username);

            $this->assertSame(
                json_encode(['id' => (string) $userId, 'email' => (string) $email, 'username' => (string) $username]),
                json_encode($account)
            );
        }
    }
}
