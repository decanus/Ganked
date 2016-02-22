<?php

 /**
 * Copyright (c) Ganked 2015
 * All rights reserved.
 */
 
namespace Ganked\API\Services
{
    use Ganked\Library\ValueObjects\Email;
    use Ganked\Library\ValueObjects\Steam\SteamId;
    use Ganked\Library\ValueObjects\UserId;
    use Ganked\Library\ValueObjects\Username;

    class UserService extends AbstractDatabaseService
    {
        /**
         * @param Username $username
         * @param array    $fields
         *
         * @return array|null
         */
        public function getUserByUsername(Username $username, $fields = [])
        {
            return $this->getUser(['username' => (string) $username], $fields);
        }

        /**
         * @param \MongoId $id
         * @param array    $fields
         *
         * @return array|null
         */
        public function getUserById(\MongoId $id, $fields = [])
        {
            return $this->getUser(['_id' => $id], $fields);
        }

        /**
         * @param SteamId $id
         * @param array   $fields
         *
         * @return array|null
         */
        public function getUserBySteamId(SteamId $id, $fields = [])
        {
            return $this->getUser(['steamIds.id' => (string) $id], $fields);
        }

        /**
         * @param array $query
         * @param array $fields
         *
         * @return array|null
         */
        private function getUser(array $query, array $fields = [])
        {
            $flipped = array_flip($fields);

            if (isset($flipped['password'])) {
                unset($fields[$flipped['password']]);
            }

            if (isset($flipped['salt'])) {
                unset($fields[$flipped['salt']]);
            }

            if (isset($flipped['hash'])) {
                unset($fields[$flipped['hash']]);
            }

            if (empty($fields)) {
                $fields = [
                    'username',
                    'firstname',
                    'lastname',
                    'email',
                    'displayname',
                    'created',
                    'default_profile',
                    'protected',
                    'profile_type',
                    'steamIds',
                    'verified'
                ];
            }

            return $this->getDatabaseBackend()->findOneInCollection('users', $query, $fields);
        }

        /**
         * @param Username $username
         *
         * @return array|null
         */
        public function getAccountWithUsername(Username $username)
        {
            return $this->getAccount(['username' => (string) $username]);
        }

        /**
         * @param Email $email
         *
         * @return array|null
         */
        public function getAccountWithEmail(Email $email)
        {
            return $this->getAccount(['email' => (string) $email]);
        }

        /**
         * @param array $query
         *
         * @return array|null
         */
        private function getAccount(array $query)
        {
            return $this->getDatabaseBackend()->findOneInCollection(
                'users',
                $query,
                ['password', 'hash', 'email', 'username', 'verified', 'salt', 'steamIds']
            );
        }

        /**
         * @param \MongoId $userId
         * @param SteamId  $steamId
         * @param string   $name
         *
         * @return bool
         */
        public function appendSteamAccountToUser(\MongoId $userId, SteamId $steamId, $name = '')
        {
            return $this->getDatabaseBackend()->updateDocument(
                'users',
                ['_id' => $userId],
                ['$push' => ['steamIds' => ['id' => (string) $steamId, 'name' => $name, 'type' => 'main']]]
            );
        }


        /**
         * @param array $user
         *
         * @return array|null
         * @throws \RuntimeException
         */
        public function createNewUser(array $user)
        {
            $user['created'] = (new \DateTime('now'))->format('c');
            $user['default_profile'] = 1;
            $user['protected'] = 0;
            $user['verified'] = 0;
            $user['profile_type'] = 'user';
            $user['displayname'] = $user['username'];

            $result = $this->getDatabaseBackend()->insertArrayInCollection($user, 'users');

            if($result['err'] !== null) {
                throw new \RuntimeException('Unknown error', 500);
            }

            return $this->getUserByUsername(new Username($user['username']));
        }

        /**
         * @param \MongoId $id
         * @param array    $user
         *
         * @return bool
         */
        public function updateUser(\MongoId $id, array $user)
        {
            return $this->getDatabaseBackend()->updateDocument('users', ['_id' => $id], ['$set' => $user])['err'] === null;
        }
    }
}
