<?php

/**
 * Copyright (c) Ganked 2015
 * All rights reserved.
 */

namespace Ganked\Frontend\Controllers
{

    use Ganked\Frontend\Models\SteamRegistrationPageModel;
    use Ganked\Frontend\Renderers\AbstractPageRenderer;
    use Ganked\Library\ValueObjects\Steam\SteamCustomId;
    use Ganked\Library\ValueObjects\Uri;
    use Ganked\Library\ValueObjects\Username;
    use Ganked\Skeleton\Commands\StorePreviousUriCommand;
    use Ganked\Skeleton\Commands\WriteSessionCommand;
    use Ganked\Skeleton\Gateways\CounterStrikeGateway;
    use Ganked\Skeleton\Http\Response\AbstractResponse;
    use Ganked\Skeleton\Models\AbstractPageModel;
    use Ganked\Skeleton\Queries\FetchSessionCookieQuery;
    use Ganked\Skeleton\Queries\FetchSteamIdFromSessionQuery;
    use Ganked\Skeleton\Queries\IsSessionStartedQuery;

    class SteamRegistrationPageController extends AbstractPageController
    {
        /**
         * @var FetchSteamIdFromSessionQuery
         */
        private $fetchSteamIdFromSessionQuery;

        /**
         * @var CounterStrikeGateway
         */
        private $counterStrikeGateway;

        /**
         * @param AbstractResponse             $response
         * @param FetchSessionCookieQuery      $fetchSessionCookieQuery
         * @param AbstractPageRenderer         $renderer
         * @param AbstractPageModel            $model
         * @param WriteSessionCommand          $writeSessionCommand
         * @param StorePreviousUriCommand      $storePreviousUriCommand
         * @param IsSessionStartedQuery        $isSessionStartedQuery
         * @param FetchSteamIdFromSessionQuery $fetchSteamIdFromSessionQuery
         *
         * @todo create general SteamGateway
         * @param CounterStrikeGateway         $counterStrikeGateway
         */
        public function __construct(
            AbstractResponse $response,
            FetchSessionCookieQuery $fetchSessionCookieQuery,
            AbstractPageRenderer $renderer,
            AbstractPageModel $model,
            WriteSessionCommand $writeSessionCommand,
            StorePreviousUriCommand $storePreviousUriCommand,
            IsSessionStartedQuery $isSessionStartedQuery,
            FetchSteamIdFromSessionQuery $fetchSteamIdFromSessionQuery,
            CounterStrikeGateway $counterStrikeGateway
        )
        {
            parent::__construct(
                $response,
                $fetchSessionCookieQuery,
                $renderer,
                $model,
                $writeSessionCommand,
                $storePreviousUriCommand,
                $isSessionStartedQuery
            );

            $this->fetchSteamIdFromSessionQuery = $fetchSteamIdFromSessionQuery;
            $this->counterStrikeGateway = $counterStrikeGateway;
        }

        protected function doRun()
        {
            try {
                $steamId = $this->fetchSteamIdFromSessionQuery->execute();
                $response = $this->counterStrikeGateway->getSteamUserInfoById((string) $steamId);

                if ($response->getHttpStatus() !== 200) {
                    return;
                }

                $data = json_decode($response->getBody(), true);

            } catch (\Exception $e) {
                return;
            }

            /**
             * @var $model SteamRegistrationPageModel
             */
            $model = $this->getModel();

            if (isset($data['response']['players'][0]['personaname'])) {
                try {
                    $model->setUsername(new Username($data['response']['players'][0]['personaname']));
                } catch (\Exception $e) {
                    // do nothing
                }
            }

            if (isset($data['response']['players'][0]['profileurl'])) {
                try {

                    $profileUri = new Uri($data['response']['players'][0]['profileurl']);

                    $explodedPath = $profileUri->getExplodedPath();

                    if (!$explodedPath[0] === 'id') {
                        return;
                    }

                    $model->setCustomId(new SteamCustomId($explodedPath[1]));

                    if (!$model->hasUsername()) {
                        $model->setUsername(new Username($explodedPath[1]));
                    }

                } catch (\Exception $e) {
                    return;
                }
            }
        }
    }
}
