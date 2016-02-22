<?php
 /**
 * Copyright (c) Ganked 2015
 * All rights reserved.
 */
 
namespace Ganked\API\Services
{
    use Ganked\Library\ValueObjects\Email;
    use Ganked\Library\ValueObjects\Username;

    /**
     * @covers \Ganked\API\Services\UserService
     * @covers \Ganked\API\Services\AbstractDatabaseService
     */
    class UserServiceTest extends \PHPUnit_Framework_TestCase
    {
        /**
         * @var UserService
         */
        private $userService;
        private $mongoDatabaseBackend;

        protected function setUp()
        {
            $this->mongoDatabaseBackend = $this->getMockBuilder(\Ganked\Library\Backends\MongoDatabaseBackend::class)
                ->disableOriginalConstructor()
                ->getMock();

            $this->userService = new UserService($this->mongoDatabaseBackend);
        }

        public function testGetUserSendsExpectedQuery()
        {
            $username = new Username('foobar');

            $this->mongoDatabaseBackend
                ->expects($this->once())
                ->method('findOneInCollection')
                ->with(
                    'users',
                    ['username' => (string) $username],
                    ['username', 'firstname', 'lastname', 'email', 'displayname', 'created', 'default_profile', 'protected', 'profile_type', 'steamIds', 'verified']
                )
                ->will($this->returnValue(['username' => 'foobar']));

            $this->assertSame(['username' => 'foobar'], $this->userService->getUserByUsername($username, ['password', 'salt', 'hash']));
        }

        public function testGetUserByIdReturnsExpectedValue()
        {
            $id = new \MongoId;

            $this->mongoDatabaseBackend
                ->expects($this->once())
                ->method('findOneInCollection')
                ->with('users', ['_id' => $id])
                ->will($this->returnValue(['foo' => 'bar']));

            $this->assertSame(['foo' => 'bar'], $this->userService->getUserById($id));
        }

        public function testGetAccountWithUsernameReturnsExpectedValue()
        {
            $username = new Username('azulio');

            $this->mongoDatabaseBackend
                ->expects($this->once())
                ->method('findOneInCollection')
                ->with('users', ['username' => (string) $username], ['password', 'hash', 'email', 'username', 'verified', 'salt', 'steamIds'])
                ->will($this->returnValue('foo'));

            $this->assertSame('foo', $this->userService->getAccountWithUsername($username));
        }

        public function testGetAccountWithEmailReturnsExpectedValue()
        {
            $email = new Email('foo@bar.net');

            $this->mongoDatabaseBackend
                ->expects($this->once())
                ->method('findOneInCollection')
                ->with('users', ['email' => (string) $email], ['password', 'hash', 'email', 'username', 'verified', 'salt', 'steamIds'])
                ->will($this->returnValue('foo'));

            $this->assertSame('foo', $this->userService->getAccountWithEmail($email));
        }

        public function testCreateNewUserWorks()
        {
            $user = ['username' => 'foo'];

            $this->mongoDatabaseBackend
                ->expects($this->once())
                ->method('insertArrayInCollection')
                ->will($this->returnValue(['err' => null]));

            $this->mongoDatabaseBackend
                ->expects($this->once())
                ->method('findOneInCollection')
                ->will($this->returnValue($user));

            $this->assertSame($user, $this->userService->createNewUser($user));
        }

        /**
         * @expectedException \RuntimeException
         */
        public function testCreateNewUserFailThrowsException()
        {
            $this->mongoDatabaseBackend
                ->expects($this->once())
                ->method('insertArrayInCollection')
                ->will($this->returnValue(['err' => 'FUCK']));

            $this->userService->createNewUser(['username' => 'foo']);
        }

        public function testUpdateUserWorks()
        {
            $id = new \MongoId;
            $data = ['foo' => 'bar'];

            $this->mongoDatabaseBackend
                ->expects($this->once())
                ->method('updateDocument')
                ->with('users', ['_id' => $id], ['$set' => $data])
                ->will($this->returnValue(['err' => null]));

            $this->assertTrue($this->userService->updateUser($id, $data));
        }
    }
}
