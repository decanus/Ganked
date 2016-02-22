<?php

/**
 * Copyright (c) Ganked 2015
 * All rights reserved.
 */

namespace Ganked\Frontend\Controllers
{

    use Ganked\Frontend\Mappers\CounterStrikeUserMapper;
    use Ganked\Frontend\Models\SteamUserPageModel;
    use Ganked\Frontend\Queries\FetchPlayerBansQuery;
    use Ganked\Frontend\Queries\ResolveVanityUrlQuery;
    use Ganked\Frontend\Renderers\AbstractPageRenderer;
    use Ganked\Library\Logging\LoggerAware;
    use Ganked\Library\Logging\LogProvider;
    use Ganked\Library\ValueObjects\Steam\SteamCustomId;
    use Ganked\Library\ValueObjects\Steam\SteamId;
    use Ganked\Library\ValueObjects\Uri;
    use Ganked\Skeleton\Commands\StorePreviousUriCommand;
    use Ganked\Skeleton\Commands\WriteSessionCommand;
    use Ganked\Skeleton\Gateways\CounterStrikeGateway;
    use Ganked\Skeleton\Http\Redirect\RedirectToPath;
    use Ganked\Skeleton\Http\Response\AbstractResponse;
    use Ganked\Skeleton\Http\StatusCodes\MovedTemporarily;
    use Ganked\Skeleton\Models\AbstractPageModel;
    use Ganked\Skeleton\Queries\FetchSessionCookieQuery;
    use Ganked\Skeleton\Queries\IsSessionStartedQuery;

    class CounterStrikeUserPageController extends AbstractPageController implements LoggerAware
    {
        /**
         * @trait
         */
        use LogProvider;

        /**
         * @var CounterStrikeUserMapper
         */
        private $counterStrikeUserMapper;

        /**
         * @var CounterStrikeGateway
         */
        private $gateway;

        /**
         * @var FetchPlayerBansQuery
         */
        private $fetchPlayerBansQuery;

        /**
         * @var ResolveVanityUrlQuery
         */
        private $resolveVanityUrlQuery;

        /**
         * @param AbstractResponse        $response
         * @param FetchSessionCookieQuery $fetchSessionCookieQuery
         * @param AbstractPageRenderer    $renderer
         * @param AbstractPageModel       $model
         * @param WriteSessionCommand     $writeSessionCommand
         * @param StorePreviousUriCommand $storePreviousUriCommand
         * @param IsSessionStartedQuery   $isSessionStartedQuery
         * @param CounterStrikeUserMapper $counterStrikeUserMapper
         * @param CounterStrikeGateway    $gateway
         * @param FetchPlayerBansQuery    $fetchPlayerBansQuery
         * @param ResolveVanityUrlQuery   $resolveVanityUrlQuery
         */
        public function __construct(
            AbstractResponse $response,
            FetchSessionCookieQuery $fetchSessionCookieQuery,
            AbstractPageRenderer $renderer,
            AbstractPageModel $model,
            WriteSessionCommand $writeSessionCommand,
            StorePreviousUriCommand $storePreviousUriCommand,
            IsSessionStartedQuery $isSessionStartedQuery,
            CounterStrikeUserMapper $counterStrikeUserMapper,
            CounterStrikeGateway $gateway,
            FetchPlayerBansQuery $fetchPlayerBansQuery,
            ResolveVanityUrlQuery $resolveVanityUrlQuery
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

            $this->counterStrikeUserMapper = $counterStrikeUserMapper;
            $this->gateway = $gateway;
            $this->fetchPlayerBansQuery = $fetchPlayerBansQuery;
            $this->resolveVanityUrlQuery = $resolveVanityUrlQuery;
        }

        protected function doRun()
        {
            $steamId = $this->getRequest()->getUri()->getExplodedPath()[3];

            /**
             * @var $model SteamUserPageModel
             */
            $model = $this->getModel();

            $isCustomId = true;

            try {
                if (!$this->isSteamCustomId($steamId) || $this->isSteamId($steamId)) {
                    throw new \InvalidArgumentException('Invalid custom id');
                }

                $resolved = $this->resolveVanityUrlQuery->execute(new SteamCustomId($steamId));
                $steamId = $resolved['response']['steamid'];
            } catch (\Exception $e) {
                $isCustomId = false;
            }

            try {
                $bans = $this->fetchPlayerBansQuery->execute([$steamId]);
                $model->setBans($bans);
            } catch (\Exception $e) {
                $this->logCriticalException($e);
            }

            $userInfo = json_decode($this->gateway->getSteamUserInfoById($steamId)->getBody(), true)['response']['players'][0];

            if (isset($userInfo['profileurl']) && !$isCustomId) {
                $url = new Uri($userInfo['profileurl']);

                $explodedPath = $url->getExplodedPath();
                if ($explodedPath[1] !== $this->getRequest()->getUri()->getExplodedPath()[3]) {
                    try {
                        $customId = new SteamCustomId($explodedPath[1]);
                        $model->setRedirect(new RedirectToPath($model->getRequestUri(), new MovedTemporarily,  '/games/cs-go/users/' . strtolower($customId)));
                        return;
                    } catch (\Exception $e) {
                        $this->logCriticalException($e);
                    }
                }
            }

            $userStats = json_decode($this->gateway->getUserStatsForGame($steamId)->getBody(), true);
            $model->setUser($this->counterStrikeUserMapper->map(array_merge($userInfo, $userStats)));
        }

        /**
         * @param string $steamCustomId
         *
         * @return bool
         */
        private function isSteamCustomId($steamCustomId)
        {
            try {
                new SteamCustomId($steamCustomId);
            } catch (\Exception $e) {
                return false;
            }

            return true;
        }

        /**
         * @param string $steamId
         *
         * @return bool
         */
        private function isSteamId($steamId)
        {
            try {
                new SteamId($steamId);
            } catch (\Exception $e) {
                return false;
            }

            return true;
        }
    }
}
