<?php

/**
 * Copyright (c) Dean Eigenmann 2015
 * All rights reserved.
 */
 
namespace Ganked\Frontend\Mappers
{

    use Ganked\Frontend\DataObjects\CounterStrike\User;

    class CounterStrikeUserMapper
    {
        /**
         * @param array $steamUserInfo
         *
         * @return User
         */
        public function map(array $steamUserInfo)
        {
            $user = new User($steamUserInfo['steamid'], $steamUserInfo['personaname']);
            $stats = [];
            if (isset($steamUserInfo['playerstats']['stats'])) {
                foreach ($steamUserInfo['playerstats']['stats'] as $stat) {
                    $stats[$stat['name']] = $stat['value'];
                }

                $user->setAchievements($steamUserInfo['playerstats']['achievements']);
                $user->setStats($stats);
            }

            $status = 'offline';
            switch ($steamUserInfo['personastate']) {
                case 1:
                    $status = 'online';
                    break;
                case 2:
                    $status = 'busy';
                    break;
                case 3:
                    $status = 'away';
                    break;
                case 4:
                    $status = 'snooze';
            }

            if (isset($steamUserInfo['gameid'])) {
                $user->setCurrentGameId($steamUserInfo['gameid']);
            }

            $user->setStatus($status);
            $user->setImage($steamUserInfo['avatarfull']);
            $user->setLastLogOff(new \DateTime('@' . $steamUserInfo['lastlogoff']));
            return $user;
        }
    }
}
