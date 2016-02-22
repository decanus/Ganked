<?php

 /**
 * Copyright (c) Ganked 2015
 * All rights reserved.
 */
 
namespace Ganked\Post\Handlers\Request
{

    use Ganked\Library\Logging\LoggerAware;
    use Ganked\Library\Logging\LogProvider;
    use Ganked\Library\ValueObjects\Email;
    use Ganked\Post\Mails\ForgotPasswordMail;
    use Ganked\Skeleton\Queries\FetchAccountQuery;
    use Ganked\Skeleton\Queries\FetchUserHashQuery;
    use Ganked\Skeleton\Session\Session;

    class ForgotPasswordMailRequestHandler extends AbstractRequestHandler implements LoggerAware
    {
        /**
         * @trait
         */
        use LogProvider;

        /**
         * @var FetchUserHashQuery
         */
        private $fetchUserHashQuery;

        /**
         * @var ForgotPasswordMail
         */
        private $forgotPasswordMail;

        /**
         * @var FetchAccountQuery
         */
        private $fetchAccountQuery;

        /**
         * @var Email
         */
        private $email;

        /**
         * @param Session            $session
         * @param FetchUserHashQuery $fetchUserHashQuery
         * @param FetchAccountQuery  $fetchAccountQuery
         * @param ForgotPasswordMail $forgotPasswordMail
         */
        public function __construct(
            Session $session,
            FetchUserHashQuery $fetchUserHashQuery,
            FetchAccountQuery $fetchAccountQuery,
            ForgotPasswordMail $forgotPasswordMail
        )
        {
            parent::__construct($session);
            $this->fetchUserHashQuery = $fetchUserHashQuery;
            $this->fetchAccountQuery = $fetchAccountQuery;
            $this->forgotPasswordMail = $forgotPasswordMail;
        }

        protected function validateForm()
        {
            $this->checkCSRFToken();

            try {
                $this->email = new Email($this->getRequest()->getParameter('email'));
            } catch (\InvalidArgumentException $e) {
                $this->setError('email', 'Please enter a valid email');
                return;
            }

            $account = $this->fetchAccountQuery->execute($this->email);

            if (isset($account['errors'])) {
                $this->setError('email', 'Please enter a valid email');
                return;
            }
        }

        protected function performAction()
        {
            $hash = $this->fetchUserHashQuery->execute($this->email);

            $this->forgotPasswordMail->setHash($hash);
            $this->forgotPasswordMail->setEmail((string) $this->email);
            $this->forgotPasswordMail->setRecipient(['email' => (string) $this->email, 'name' => '']);

            try {
                $this->forgotPasswordMail->send();
            } catch (\Exception $e) {
                $this->logEmergencyException($e);
                $this->setErrorMessage('Something went wrong, please try again later.');
                return;
            }

            $this->setSuccessMessage('We have sent you an email with further steps');
        }
    }
}
