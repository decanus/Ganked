<?php

 /**
 * Copyright (c) Ganked 2015
 * All rights reserved.
 */
 
namespace Ganked\Post\Handlers\Redirect
{

    use Ganked\Library\Logging\LoggerAware;
    use Ganked\Library\Logging\LogProvider;
    use Ganked\Library\ValueObjects\Email;
    use Ganked\Post\Mails\VerifyMail;
    use Ganked\Skeleton\Queries\FetchAccountQuery;

    class ResendVerificationMailRedirectHandler extends AbstractRedirectHandler implements LoggerAware
    {
        /**
         * @trait
         */
        use LogProvider;

        /**
         * @var FetchAccountQuery
         */
        private $fetchAccountQuery;

        /**
         * @var VerifyMail
         */
        private $mail;

        /**
         * @param bool              $isDevelopment
         * @param FetchAccountQuery $fetchAccountQuery
         * @param VerifyMail        $mail
         */
        public function __construct(
            $isDevelopment = false,
            FetchAccountQuery $fetchAccountQuery,
            VerifyMail $mail
        )
        {
            parent::__construct($isDevelopment);
            $this->fetchAccountQuery = $fetchAccountQuery;
            $this->mail = $mail;
        }

        /**
         * @return array
         */
        protected function doExecute()
        {
            $request = $this->getRequest();
            $result = $this->fetchAccountQuery->execute(new Email($request->getParameter('email')));

            if (!isset($result['errors'])) {
                $data = $result['data']['attributes'];
                $this->mail->setHash($data['hash']);
                $this->mail->setRecipient(
                    ['email' => (string) $data['email'], 'name' =>  $data['username']]
                );

                try {
                    $this->mail->send();
                } catch (\Exception $e) {
                    $this->logEmergencyException($e);
                }
            }

            $this->getModel()->setRedirectUri($this->redirectToPath('/login'));
        }
    }
}
