<?php

/**
 * Copyright (c) Ganked 2015
 * All rights reserved.
 */

namespace Ganked\Frontend\Controllers
{

    use Ganked\Frontend\Commands\LockSessionForSteamLoginCommand;
    use Ganked\Frontend\Commands\SaveSteamIdInSessionCommand;
    use Ganked\Frontend\Renderers\AbstractPageRenderer;
    use Ganked\Library\DataObjects\Accounts\RegisteredAccount;
    use Ganked\Library\ValueObjects\Steam\SteamId;
    use Ganked\Library\ValueObjects\Uri;
    use Ganked\Skeleton\Commands\StorePreviousUriCommand;
    use Ganked\Skeleton\Commands\WriteSessionCommand;
    use Ganked\Skeleton\Http\Redirect\RedirectToPath;
    use Ganked\Skeleton\Http\Redirect\RedirectToUri;
    use Ganked\Skeleton\Http\Response\AbstractResponse;
    use Ganked\Skeleton\Http\StatusCodes\MovedTemporarily;
    use Ganked\Skeleton\Models\AbstractPageModel;
    use Ganked\Skeleton\Queries\FetchSessionCookieQuery;
    use Ganked\Skeleton\Queries\HasUserBySteamIdQuery;
    use Ganked\Skeleton\Queries\IsSessionStartedQuery;

    class SteamLoginController extends AbstractPageController
    {
        /**
         * @var \LightOpenID
         */
        private $openID;

        /**
         * @var LockSessionForSteamLoginCommand
         */
        private $lockSessionForSteamLoginCommand;

        /**
         * @var SaveSteamIdInSessionCommand
         */
        private $saveSteamIdInSessionCommand;

        /**
         * @var HasUserBySteamIdQuery
         */
        private $hasUserBySteamIdQuery;

        /**
         * @param AbstractResponse                $response
         * @param FetchSessionCookieQuery         $fetchSessionCookieQuery
         * @param AbstractPageRenderer            $renderer
         * @param AbstractPageModel               $model
         * @param WriteSessionCommand             $writeSessionCommand
         * @param StorePreviousUriCommand         $storePreviousUriCommand
         * @param IsSessionStartedQuery           $isSessionStartedQuery
         * @param \LightOpenID                    $openID
         * @param LockSessionForSteamLoginCommand $lockSessionForSteamLoginCommand
         * @param SaveSteamIdInSessionCommand     $saveSteamIdInSessionCommand
         * @param HasUserBySteamIdQuery           $hasUserBySteamIdQuery
         */
        public function __construct(
            AbstractResponse $response,
            FetchSessionCookieQuery $fetchSessionCookieQuery,
            AbstractPageRenderer $renderer,
            AbstractPageModel $model,
            WriteSessionCommand $writeSessionCommand,
            StorePreviousUriCommand $storePreviousUriCommand,
            IsSessionStartedQuery $isSessionStartedQuery,
            \LightOpenID $openID,
            LockSessionForSteamLoginCommand $lockSessionForSteamLoginCommand,
            SaveSteamIdInSessionCommand $saveSteamIdInSessionCommand,
            HasUserBySteamIdQuery $hasUserBySteamIdQuery
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

            $this->hasUserBySteamIdQuery = $hasUserBySteamIdQuery;
            $this->openID = $openID;
            $this->lockSessionForSteamLoginCommand = $lockSessionForSteamLoginCommand;
            $this->saveSteamIdInSessionCommand = $saveSteamIdInSessionCommand;
        }

        protected function doRun()
        {
            $request = $this->getRequest();

            if (!$this->openID->mode || $this->openID->mode === 'cancel' || !$this->openID->validate() || !$request->hasParameter('openid_claimed_id')) {
                return;
            }

            $claimedId = new SteamId((new Uri($request->getParameter('openid_claimed_id')))->getExplodedPath()[2]);

            $model = $this->getModel();

            $model->setRedirect(new RedirectToPath($request->getUri(), new MovedTemporarily ,'/register/steam'));
            if ($this->hasUserBySteamIdQuery->execute($claimedId)) {
                $model->setRedirect(new RedirectToUri(new Uri('https://post.ganked.net/action/login/steam'), new MovedTemporarily));
            }

            $this->lockSessionForSteamLoginCommand->execute();
            $this->saveSteamIdInSessionCommand->execute($claimedId);
        }
    }
}
