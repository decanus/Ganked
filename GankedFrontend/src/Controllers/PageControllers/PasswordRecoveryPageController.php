<?php

 /**
 * Copyright (c) Ganked 2015
 * All rights reserved.
 */
 
namespace Ganked\Frontend\Controllers
{

    use Ganked\Frontend\Models\PasswordRecoveryPageModel;
    use Ganked\Frontend\Renderers\AbstractPageRenderer;
    use Ganked\Library\ValueObjects\Email;
    use Ganked\Skeleton\Commands\StorePreviousUriCommand;
    use Ganked\Skeleton\Commands\WriteSessionCommand;
    use Ganked\Skeleton\Http\Response\AbstractResponse;
    use Ganked\Skeleton\Models\AbstractPageModel;
    use Ganked\Skeleton\Queries\FetchSessionCookieQuery;
    use Ganked\Skeleton\Queries\FetchUserHashQuery;
    use Ganked\Skeleton\Queries\IsSessionStartedQuery;

    class PasswordRecoveryPageController extends AbstractPageController
    {
        /**
         * @var FetchUserHashQuery
         */
        private $fetchUserHashQuery;

        /**
         * @param AbstractResponse $response
         * @param FetchSessionCookieQuery $fetchSessionCookieQuery
         * @param AbstractPageRenderer $renderer
         * @param AbstractPageModel $model
         * @param WriteSessionCommand $writeSessionCommand
         * @param StorePreviousUriCommand $storePreviousUriCommand
         * @param IsSessionStartedQuery $isSessionStartedQuery
         * @param FetchUserHashQuery $fetchUserHashQuery
         */
        public function __construct(
            AbstractResponse $response,
            FetchSessionCookieQuery $fetchSessionCookieQuery,
            AbstractPageRenderer $renderer,
            AbstractPageModel $model,
            WriteSessionCommand $writeSessionCommand,
            StorePreviousUriCommand $storePreviousUriCommand,
            IsSessionStartedQuery $isSessionStartedQuery,
            FetchUserHashQuery $fetchUserHashQuery
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

            $this->fetchUserHashQuery = $fetchUserHashQuery;
        }

        protected function doRun()
        {
            /**
             * @var $model PasswordRecoveryPageModel
             */
            $model = $this->getModel();
            $uri = $model->getRequestUri();

            try {

                $email = new Email($uri->getParameter('email'));
                $model->setEmail($email);

                $hash = $uri->getParameter('hash');
                $model->setHash($hash);

                if ($this->fetchUserHashQuery->execute($email) !== $hash || $hash === null) {
                    throw new \RuntimeException('Hashes do not match');
                }

                $model->hashIsValid();

            } catch (\Exception $e) {
                $model->hashIsInvalid();
            }
        }
    }
}
