<?php
 /**
 * Copyright (c) Dean Eigenmann 2015
 * All rights reserved.
 */

namespace Ganked\Skeleton\Session
{

    use Ganked\Library\DataObjects\Accounts\AccountInterface;
    use Ganked\Library\DataObjects\Accounts\AnonymousAccount;
    use Ganked\Library\DataObjects\Accounts\RegisteredAccount;
    use Ganked\Library\ValueObjects\Email;
    use Ganked\Library\ValueObjects\LeagueOfLegends\Region;
    use Ganked\Library\ValueObjects\Steam\SteamId;
    use Ganked\Library\ValueObjects\Token;
    use Ganked\Library\ValueObjects\Uri;
    use Ganked\Library\ValueObjects\UserId;
    use Ganked\Library\ValueObjects\Username;
    use Ganked\Skeleton\Map;

    class SessionData
    {
        /**
         * @var Map
         */
        private $map;

        /**
         * @param Map $map
         */
        public function __construct(Map $map)
        {
            $this->map = $map;
        }

        /**
         * @param Uri $uri
         *
         * @throws \Ganked\Skeleton\Exceptions\MapException
         */
        public function setPreviousUri(Uri $uri)
        {
            $this->getMap()->set('previousUri', $uri);
        }

        /**
         * @return string
         * @throws \Ganked\Skeleton\Exceptions\MapException
         */
        public function getPreviousUri()
        {
            return $this->getMap()->get('previousUri');
        }

        public function removePreviousUri()
        {
            $this->getMap()->remove('previousUri');
        }

        /**
         * @return bool
         */
        public function hasPreviousUri()
        {
            return $this->getMap()->has('previousUri');
        }

        /**
         * @return array
         * @throws \Ganked\Skeleton\Exceptions\MapException
         */
        public function getUser()
        {
            return json_decode($this->getMap()->get('account'), true);
        }

        public function removeAccount()
        {
            $this->getMap()->remove('account');
        }

        /**
         * @return bool
         */
        public function hasUser()
        {
            return $this->getMap()->has('account');
        }

        /**
         * @param Region $region
         *
         * @throws \Ganked\Skeleton\Exceptions\MapException
         */
        public function setDefaultLeagueOfLegendsRegion(Region $region)
        {
            $this->getMap()->set('lol:region', (string) $region);
        }

        /**
         * @return Region
         * @throws \Ganked\Skeleton\Exceptions\MapException
         */
        public function getDefaultLeagueOfLegendsRegion()
        {
            return new Region($this->getMap()->get('lol:region'));
        }

        /**
         * @return AccountInterface
         * @throws \Ganked\Skeleton\Exceptions\MapException
         */
        public function getAccount()
        {
            if (!$this->getMap()->has('account')) {
                return new AnonymousAccount;
            }

            $account = json_decode($this->getMap()->get('account'), true);
            return new RegisteredAccount(new UserId($account['id']), new Email($account['email']), new Username($account['username']));
        }

        /**
         * @param RegisteredAccount $account
         *
         * @throws \Ganked\Skeleton\Exceptions\MapException
         */
        public function setAccount(RegisteredAccount $account)
        {
            $this->getMap()->set('account', json_encode($account));
        }

        /**
         * @return bool
         */
        public function hasDefaultLeagueOfLegendsRegion()
        {
            return $this->getMap()->has('lol:region');
        }

        public function removeDefaultLeagueOfLegendsRegion()
        {
            $this->getMap()->remove('lol:region');
        }

        /**
         * @return Token
         * @throws \Ganked\Skeleton\Exceptions\MapException
         */
        public function getToken()
        {
            return new Token($this->getMap()->get('token'));
        }

        public function lockSessionForSteamLogin()
        {
            $this->getMap()->set('isSteamLoginLocked', 'true');
        }

        public function unlockSessionFromSteamLogin()
        {
            $this->getMap()->remove('isSteamLoginLocked');
        }

        /**
         * @return bool
         */
        public function hasSteamId()
        {
            return $this->getMap()->has('steamId');
        }

        /**
         * @param SteamId $steamId
         *
         * @throws \Ganked\Skeleton\Exceptions\MapException
         */
        public function setSteamId(SteamId $steamId)
        {
            $this->getMap()->set('steamId', (string) $steamId);
        }

        /**
         * @return SteamId
         *
         * @throws \Ganked\Skeleton\Exceptions\MapException
         */
        public function getSteamId()
        {
            return new SteamId($this->getMap()->get('steamId'));
        }

        public function removeSteamId()
        {
            if (!$this->getMap()->has('steamId')) {
                return;
            }

            $this->getMap()->remove('steamId');
        }

        /**
         * @return bool
         * @throws \Ganked\Skeleton\Exceptions\MapException
         */
        public function isSteamLoginLocked()
        {
            if (!$this->getMap()->has('isSteamLoginLocked')) {
                return false;
            }

            return $this->getMap()->get('isSteamLoginLocked') === 'true';
        }

        /**
         * @return Map
         */
        public function getMap()
        {
            return $this->map;
        }
    }
}
