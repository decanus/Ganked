<?php
/**
 * Copyright (c) Ganked 2015
 * All rights reserved.
 */
namespace Ganked\Services\ServiceClients\Account
{

    use Ganked\Library\Backends\MongoDatabaseBackend;
    use Ganked\Library\ValueObjects\Email;
    use Ganked\Library\ValueObjects\Hash;
    use Ganked\Services\ServiceClients\AbstractServiceClient;

    class AccountServiceClient extends AbstractServiceClient
    {
        /**
         * @var MongoDatabaseBackend
         */
        private $mongoDatabaseBackend;

        /**
         * @param MongoDatabaseBackend $mongoDatabaseBackend
         */
        public function __construct(MongoDatabaseBackend $mongoDatabaseBackend)
        {
            $this->mongoDatabaseBackend = $mongoDatabaseBackend;
            $this->mongoDatabaseBackend->connect();
        }

        /**
         * @param Email $email
         * @return array|null
         */
        public function isVerifiedForBeta($email)
        {
            $result = $this->mongoDatabaseBackend->findOneInCollection(
                'betarequest', ['email' => (string) $email],
                ['verified']
            );

            if ($result === null) {
                return json_encode(false);
            }

            return json_encode($result['verified'] === 1);
        }

        /**
         * @param string $email
         * @return bool
         */
        public function setUserVerified($email)
        {
            return json_encode($this->mongoDatabaseBackend->updateDocument(
                'users',
                ['email' => $email],
                ['$set' => ['verified' => 1]]
            ));
        }

        /**
         * @param $email
         * @param $hash
         * @return string
         */
        public function setUserHash($email, $hash)
        {
            return json_encode($this->mongoDatabaseBackend->updateDocument(
                'users',
                ['email' => $email],
                ['$set' => ['hash' => $hash]]
            ));
        }


        /**
         * @param string $email
         * @return bool
         */
        public function setBetaRequestVerified($email)
        {
            return json_encode($this->mongoDatabaseBackend->updateDocument(
                'betarequest',
                ['email' => $email],
                ['$set' => ['verified' => 1]]
            ));
        }

        /**
         * @param Email $email
         * @return string
         */
        public function getUserHash($email)
        {
            return json_encode($this->mongoDatabaseBackend->findOneInCollection('users', ['email' => (string) $email], ['hash']));
        }

        /**
         * @param $email
         * @return bool
         */
        public function hasBetaRequest($email)
        {
            return json_encode(
                $this->mongoDatabaseBackend->findOneInCollection('betarequest', ['email' => (string)$email]) !== null
            );
        }

        /**
         * @param Hash $password
         * @param Email $email
         * @return bool
         */
        public function updateUserPassword($password, $email)
        {
            return json_encode($this->mongoDatabaseBackend->updateDocument(
                'users',
                ['email' => (string) $email],
                ['$set' => ['password' => (string) $password]]
            )['err'] === null);
        }

        public function __call($method, $args)
        {
            $this->mongoDatabaseBackend->closeConnection();
        }
    }
}
