<?php

 /**
 * Copyright (c) Ganked 2015
 * All rights reserved.
 */
 
namespace Ganked\Post\Handlers\Request
{

    use Ganked\Library\ValueObjects\Post;
    use Ganked\Post\Commands\CreateNewPostCommand;
    use Ganked\Skeleton\Queries\SessionHasUserQuery;
    use Ganked\Skeleton\Session\Session;

    class CreateNewPostRequestHandler extends AbstractRequestHandler
    {
        /**
         * @var CreateNewPostCommand
         */
        private $createNewPostCommand;

        /**
         * @var Post
         */
        private $post;

        /**
         * @var SessionHasUserQuery
         */
        private $sessionHasUserQuery;

        /**
         * @param Session              $session
         * @param CreateNewPostCommand $createNewPostCommand
         * @param SessionHasUserQuery  $sessionHasUserQuery
         */
        public function __construct(
            Session $session,
            CreateNewPostCommand $createNewPostCommand,
            SessionHasUserQuery $sessionHasUserQuery
        )
        {
            parent::__construct($session);
            $this->createNewPostCommand = $createNewPostCommand;
            $this->sessionHasUserQuery = $sessionHasUserQuery;
        }

        protected function validateForm()
        {
            try {
                $this->checkCSRFToken();
            } catch (\Exception $e) {
                $this->setErrorMessage('Something went wrong, please try again later');
                return;
            }

            $request = $this->getRequest();

            if (!$this->sessionHasUserQuery->execute()) {
                $this->setErrorMessage('Something went wrong, please try again later');
                return;
            }

            try {
                $this->post = new Post($request->getParameter('post'));
            } catch (\Exception $e) {
                $this->setErrorMessage('Your post cannot contain more than 300 characters.');
                return;
            }
        }

        protected function performAction()
        {
            if (!$this->createNewPostCommand->execute($this->post, $this->getSessionData()->getAccount()->getId())) {
                $this->setErrorMessage('Something went wrong please try again later');
            }
        }
    }
}
