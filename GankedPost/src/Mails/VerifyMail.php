<?php

/**
 * Copyright (c) Dean Eigenmann 2015
 * All rights reserved.
 */

namespace Ganked\Post\Mails
{

    use Ganked\Library\Helpers\DomHelper;

    class VerifyMail extends AbstractMail
    {
        /**
         * @var string
         */
        private $hash;

        /**
         * @param string $hash
         */
        public function setHash($hash)
        {
            $this->hash = $hash;
        }

        /**
         * @return DomHelper
         */
        protected function render()
        {
            $this->setSubject('Verification - Ganked.net');

            $recipient = $this->getRecipient();
            $mail = $this->getMailTemplate('templates://mails/verifyMail.xhtml');
            $links = $mail->getElementsByTagName('a');

            $host = 'www';
            if ($this->isDevelopmentMode()) {
                $host = 'dev';
            }

            $links->item(1)->setAttribute(
                'href',
                'https://' . $host .'.ganked.net/account/verify?email=' . $recipient['email'] . '&hash=' . $this->hash
            );

            $links->item(0)->setAttribute('href', 'http://ganked.net');

            return $mail;
        }
    }
}
