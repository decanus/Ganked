<?php

/**
 * Copyright (c) Ganked 2015
 * All rights reserved.
 */

namespace Ganked\Post\Handlers\Redirect
{

    use Ganked\Library\ValueObjects\Email;
    use Ganked\Library\ValueObjects\Uri;
    use Ganked\Library\ValueObjects\Username;
    use Ganked\Post\Commands\LoginUserCommand;
    use Ganked\Post\Commands\RemoveSteamIdFromSessionCommand;
    use Ganked\Post\Commands\UnlockSessionFromSteamLoginCommand;
    use Ganked\Skeleton\Queries\FetchPreviousUriQuery;
    use Ganked\Skeleton\Queries\FetchSteamIdFromSessionQuery;
    use Ganked\Skeleton\Queries\FetchUserWithSteamIdQuery;

    class SteamLoginRedirectHandler extends AbstractRedirectHandler
    {
        /**
         * @var FetchSteamIdFromSessionQuery
         */
        private $fetchSteamIdFromSessionQuery;

        /**
         * @var UnlockSessionFromSteamLoginCommand
         */
        private $unlockSessionFromSteamLoginCommand;

        /**
         * @var LoginUserCommand
         */
        private $loginUserCommand;

        /**
         * @var FetchUserWithSteamIdQuery
         */
        private $fetchUserWithSteamIdQuery;

        /**
         * @var FetchPreviousUriQuery
         */
        private $fetchPreviousUriQuery;

        /**
         * @var RemoveSteamIdFromSessionCommand
         */
        private $removeSteamIdFromSessionCommand;

        /**
         * @param bool                               $isDevelopment
         * @param FetchSteamIdFromSessionQuery       $fetchSteamIdFromSessionQuery
         * @param UnlockSessionFromSteamLoginCommand $unlockSessionFromSteamLoginCommand
         * @param LoginUserCommand                   $loginUserCommand
         * @param FetchUserWithSteamIdQuery          $fetchUserWithSteamIdQuery
         * @param FetchPreviousUriQuery              $fetchPreviousUriQuery
         * @param RemoveSteamIdFromSessionCommand    $removeSteamIdFromSessionCommand
         */
        public function __construct(
            $isDevelopment = false,
            FetchSteamIdFromSessionQuery $fetchSteamIdFromSessionQuery,
            UnlockSessionFromSteamLoginCommand $unlockSessionFromSteamLoginCommand,
            LoginUserCommand $loginUserCommand,
            FetchUserWithSteamIdQuery $fetchUserWithSteamIdQuery,
            FetchPreviousUriQuery $fetchPreviousUriQuery,
            RemoveSteamIdFromSessionCommand $removeSteamIdFromSessionCommand
        )
        {
            parent::__construct($isDevelopment);
            $this->fetchSteamIdFromSessionQuery = $fetchSteamIdFromSessionQuery;
            $this->unlockSessionFromSteamLoginCommand = $unlockSessionFromSteamLoginCommand;
            $this->loginUserCommand = $loginUserCommand;
            $this->fetchUserWithSteamIdQuery = $fetchUserWithSteamIdQuery;
            $this->fetchPreviousUriQuery = $fetchPreviousUriQuery;
            $this->removeSteamIdFromSessionCommand = $removeSteamIdFromSessionCommand;
        }

        /**
         * @return array
         */
        protected function doExecute()
        {
            $model = $this->getModel();
            $this->unlockSessionFromSteamLoginCommand->execute();

            try {
                $steamId = $this->fetchSteamIdFromSessionQuery->execute();
            } catch (\Exception $e) {
                $model->setRedirectUri($this->redirectToPath('/login/steam'));
                return;
            }

            $user = $this->fetchUserWithSteamIdQuery->execute($steamId);

            if (isset($user['errors'])) {
                $model->setRedirectUri($this->redirectToPath('/login/steam'));
                return;
            }

            if (!isset($user['data'])) {
                $model->setRedirectUri($this->redirectToPath('/login/steam'));
                return;
            }

            $user = $user['data'];

            $this->loginUserCommand->execute(
                new Email($user['attributes']['email']),
                new Username($user['attributes']['username']),
                (string) $user['id']
            );

            $model->setRedirectUri(new Uri($this->fetchPreviousUriQuery->execute($this->redirectToPath('/'))));
            $this->removeSteamIdFromSessionCommand->execute();
        }
    }
}
