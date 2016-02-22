<?php
/**
* Copyright (c) Ganked 2015
* All rights reserved.
*/

namespace Ganked\Services\ServiceClients\Account
{

    use Ganked\Library\ValueObjects\Email;
    use Ganked\Library\ValueObjects\Hash;

    class AccountServiceClientTest extends \PHPUnit_Framework_TestCase
    {

        /**
         * @var \Ganked\Services\ServiceClients\Account\AccountServiceClient
         */
        private $accountServiceClient;
        private $mongoDatabaseBackend;

        public function setUp()
        {
            $this->mongoDatabaseBackend = $this->getMockBuilder(\Ganked\Library\Backends\MongoDatabaseBackend::class)->disableOriginalConstructor()->getMock();

            $this->mongoDatabaseBackend
                ->expects($this->any())
                ->method('connect');

            $this->accountServiceClient = new AccountServiceClient($this->mongoDatabaseBackend);
        }

        public function testIsVerifiedForBetaReturnsExpectedValue()
        {
            $email = new Email('sam.bluub@fancy.glub');

            $this->mongoDatabaseBackend
                ->expects($this->at(0))
                ->method('findOneInCollection')
                ->with('betarequest', ['email' => (string) $email], ['verified'])
                ->will($this->returnValue(['verified' => 0]));

            $this->mongoDatabaseBackend
                ->expects($this->at(1))
                ->method('findOneInCollection')
                ->with('betarequest', ['email' => (string) $email], ['verified'])
                ->will($this->returnValue(null));

            $this->assertSame('false', $this->accountServiceClient->isVerifiedForBeta($email));
            $this->assertSame('false', $this->accountServiceClient->isVerifiedForBeta($email));
        }

        public function testSetUserVerifiedReturnsExpectedValue()
        {
            $email = new Email('sam.bluub@fancy.glub');
            $mongoReturn = [];

            $this->mongoDatabaseBackend
                ->expects($this->once())
                ->method('updateDocument')
                ->with('users', ['email' => $email], ['$set' => ['verified' => '1']])
                ->will($this->returnValue($mongoReturn));

            $this->assertSame(json_encode($mongoReturn), $this->accountServiceClient->setUserVerified($email));
        }

        public function testGetUserHashReturnsExpectedValue()
        {
            $email = new Email('sam.bluub@fancy.glub');
            $mongoReturn = [];

            $this->mongoDatabaseBackend
                ->expects($this->once())
                ->method('findOneInCollection')
                ->with('users', ['email' => (string) $email], ['hash'])
                ->will($this->returnValue($mongoReturn));

            $this->assertSame(json_encode($mongoReturn), $this->accountServiceClient->getUserHash($email));
        }

        public function testHasBetaRequestReturnsExpectedValue()
        {
            $email = new Email('sam.bluub@fancy.glub');

            $this->mongoDatabaseBackend
                ->expects($this->once())
                ->method('findOneInCollection')
                ->with('betarequest', ['email' => (string) $email])
                ->will($this->returnValue(true));

            $this->assertSame('true', $this->accountServiceClient->hasBetaRequest($email));
        }

        public function testSetUserHashWorks()
        {
            $email = 'test@ganked.net';
            $hash = 'hash';

            $this->mongoDatabaseBackend
                ->expects($this->once())
                ->method('updateDocument')
                ->with('users', ['email' => $email], ['$set' => ['hash' => $hash]])
                ->will($this->returnValue([]));

            $this->accountServiceClient->setUserHash($email, $hash);
        }

        public function testSetBetaUserVerifiedWorks()
        {
            $email = 'test@ganked.net';

            $this->mongoDatabaseBackend
                ->expects($this->once())
                ->method('updateDocument')
                ->with('betarequest', ['email' => $email], ['$set' => ['verified' => 1]])
                ->will($this->returnValue([]));

            $this->accountServiceClient->setBetaRequestVerified($email);
        }

        public function testUpdateUserPasswordReturnsExpectedValue()
        {
            $email = new Email('sam.bluub@fancy.glub');
            $hash = new Hash('bloob');
            $mongoReturn = ['err' => null];

            $this->mongoDatabaseBackend
                ->expects($this->once())
                ->method('updateDocument')
                ->with('users', ['email' => (string) $email], ['$set' => ['password' => (string) $hash]])
                ->will($this->returnValue($mongoReturn));

            $this->assertSame('true', $this->accountServiceClient->updateUserPassword($hash, $email));
        }
    }
}