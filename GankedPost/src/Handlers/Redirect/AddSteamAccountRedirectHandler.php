<?php

/**
 * Copyright (c) Ganked 2015
 * All rights reserved.
 */

namespace Ganked\Post\Handlers\Redirect
{

    use Ganked\Library\DataObjects\Accounts\RegisteredAccount;
    use Ganked\Post\Commands\ConnectSteamAccountToUserCommand;
    use Ganked\Post\Commands\RemoveSteamIdFromSessionCommand;
    use Ganked\Skeleton\Gateways\CounterStrikeGateway;
    use Ganked\Skeleton\Http\Redirect\RedirectToUri;
    use Ganked\Skeleton\Http\StatusCodes\MovedTemporarily;
    use Ganked\Skeleton\Queries\FetchAccountFromSessionQuery;
    use Ganked\Skeleton\Queries\FetchSteamIdFromSessionQuery;
    use Ganked\Skeleton\Queries\FetchUserFromSessionQuery;
    use Ganked\Skeleton\Queries\FetchUserWithSteamIdQuery;

    class AddSteamAccountRedirectHandler extends AbstractRedirectHandler
    {
        /**
         * @var FetchUserWithSteamIdQuery
         */
        private $fetchUserWithSteamIdQuery;

        /**
         * @var FetchSteamIdFromSessionQuery
         */
        private $fetchSteamIdFromSessionQuery;

        /**
         * @var CounterStrikeGateway
         */
        private $counterStrikeGateway;

        /**
         * @var FetchUserFromSessionQuery
         */
        private $fetchAccountFromSessionQuery;

        /**
         * @var ConnectSteamAccountToUserCommand
         */
        private $connectSteamAccountToUserCommand;

        /**
         * @var RemoveSteamIdFromSessionCommand
         */
        private $removeSteamIdFromSessionCommand;

        /**
         * @param bool|false                       $isDevelopment
         * @param FetchUserWithSteamIdQuery        $fetchUserWithSteamIdQuery
         * @param FetchSteamIdFromSessionQuery     $fetchSteamIdFromSessionQuery
         * @param CounterStrikeGateway             $counterStrikeGateway
         * @param FetchAccountFromSessionQuery     $fetchAccountFromSessionQuery
         * @param ConnectSteamAccountToUserCommand $connectSteamAccountToUserCommand
         * @param RemoveSteamIdFromSessionCommand  $removeSteamIdFromSessionCommand
         */
        public function __construct(
            $isDevelopment = false,
            FetchUserWithSteamIdQuery $fetchUserWithSteamIdQuery,
            FetchSteamIdFromSessionQuery $fetchSteamIdFromSessionQuery,
            CounterStrikeGateway $counterStrikeGateway,
            FetchAccountFromSessionQuery $fetchAccountFromSessionQuery,
            ConnectSteamAccountToUserCommand $connectSteamAccountToUserCommand,
            RemoveSteamIdFromSessionCommand $removeSteamIdFromSessionCommand
        )
        {
            parent::__construct($isDevelopment);

            $this->fetchUserWithSteamIdQuery = $fetchUserWithSteamIdQuery;
            $this->fetchSteamIdFromSessionQuery = $fetchSteamIdFromSessionQuery;
            $this->counterStrikeGateway = $counterStrikeGateway;
            $this->fetchAccountFromSessionQuery = $fetchAccountFromSessionQuery;
            $this->connectSteamAccountToUserCommand = $connectSteamAccountToUserCommand;
            $this->removeSteamIdFromSessionCommand = $removeSteamIdFromSessionCommand;
        }

        /**
         * @return array
         */
        protected function doExecute()
        {
            $model = $this->getModel();

            try {

                $user = $this->fetchAccountFromSessionQuery->execute();

                if (!$user instanceof RegisteredAccount) {
                    throw new \Exception('User must be logged in');
                }

                $steamId = $this->fetchSteamIdFromSessionQuery->execute();
                $response = $this->counterStrikeGateway->getSteamUserInfoById((string) $steamId);

                if ($response->getHttpStatus() !== 200) {
                    throw new \Exception('Invalid SteamId');
                }

                $data = json_decode($response->getBody(), true);

                $steamName = '';
                if (isset($data['response']['players'][0]['personaname'])) {
                    $steamName = $data['response']['players'][0]['personaname'];
                }

                $result = $this->connectSteamAccountToUserCommand->execute($user->getId(), $steamId, $steamName);

                if ($result->getResponseCode() !== 200) {
                    throw new \RuntimeException('Something went wrong');
                }

                $model->setRedirect(new RedirectToUri($this->redirectToPath('/account'), new MovedTemporarily));

            } catch (\Exception $e) {
                $model->setRedirect(new RedirectToUri($this->redirectToPath('/connect/steam'), new MovedTemporarily));
            }

            $this->removeSteamIdFromSessionCommand->execute();
        }
    }
}
