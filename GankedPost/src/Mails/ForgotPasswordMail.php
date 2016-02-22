<?php

/**
 * Copyright (c) Dean Eigenmann 2015
 * All rights reserved.
 */
 
namespace Ganked\Post\Mails
{

    use Ganked\Library\Helpers\DomHelper;

    class ForgotPasswordMail extends AbstractMail
    {
        /**
         * @var string
         */
        private $hash;

        /**
         * @var string
         */
        private $email;

        /**
         * @param string $hash
         */
        public function setHash($hash)
        {
            $this->hash = $hash;
        }

        /**
         * @param string $email
         */
        public function setEmail($email)
        {
            $this->email = $email;
        }

        /**
         * @return DomHelper
         */
        protected function render()
        {
            $this->setSubject('Password Recovery - Ganked.net');

            $mail = $this->getMailTemplate('templates://mails/forgotPassword.xhtml');
            $links = $mail->getElementsByTagName('a');

            $links->item(0)->setAttribute('href', 'http://ganked.net');
            $links->item(1)->setAttribute(
                'href',
                'https://ganked.net/recover-password?hash=' . $this->hash . '&email=' . $this->email
            );

            return $mail;
        }
    }
}
