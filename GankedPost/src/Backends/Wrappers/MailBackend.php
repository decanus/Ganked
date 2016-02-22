<?php

/**
 * Copyright (c) Dean Eigenmann 2015
 * All rights reserved.
 */
 
namespace Ganked\Post\Backends
{

    use Ganked\Library\Helpers\DomHelper;
    use Ganked\Library\ValueObjects\Email;
    use PHPMailer;

    class MailBackend
    {
        /**
         * @var string
         */
        private $host;

        /**
         * @var string
         */
        private $username;

        /**
         * @var string
         */
        private $password;

        /**
         * @var PHPMailer
         */
        private $mailer;

        /**
         * @var bool
         */
        private $isPrepared = false;

        /**
         * @param string    $host
         * @param string    $username
         * @param string    $password
         * @param PHPMailer $mailer
         */
        public function __construct($host, $username, $password, PHPMailer $mailer)
        {
            $this->host = $host;
            $this->username = $username;
            $this->password = $password;

            $this->mailer = $mailer;
        }

        private function prepare()
        {
            if ($this->isPrepared()) {
                return;
            }

            $this->mailer->isSMTP();
            $this->mailer->SMTPSecure = 'ssl';
            $this->mailer->Port = 465;
            $this->mailer->Host = $this->host;
            $this->mailer->Username = $this->username;
            $this->mailer->Password = $this->password;

            $this->mailer->SMTPOptions = [
                'ssl' => [
                    'verify_peer'  => false,
                    'verify_depth' => 3,
                    'allow_self_signed' => true,
                    'peer_name' => 'smtp.mail-ch.ch',
                ]
            ];

            $this->mailer->SMTPAuth = true;

            $this->mailer->isHTML(true);
            $this->isPrepared = true;
        }

        /**
         * @param array $recipients
         */
        public function setRecipients(array $recipients)
        {
            foreach ($recipients as $recipient) {
                $this->mailer->addAddress($recipient['email'], $recipient['name']);
            }
        }

        /**
         * @param array $recipient
         */
        public function setRecipient(array $recipient)
        {
            $this->mailer->addAddress($recipient['email'], $recipient['name']);
        }

        /**
         * @param string $subject
         */
        public function setSubject($subject)
        {
            $this->mailer->Subject = $subject;
        }

        /**
         * @param DomHelper $document
         */
        public function setHTMLBody(DomHelper $document)
        {
            $this->mailer->msgHTML($document->saveXML());
        }

        /**
         * @param Email $email
         * @param string $name
         */
        public function setSender(Email $email, $name = 'Ganked.net')
        {
            $this->mailer->setFrom((string) $email, $name);
        }

        /**
         * @throws \Exception
         * @throws \phpmailerException
         */
        public function send()
        {
            if (!$this->isPrepared()) {
                $this->prepare();
            }

            $this->mailer->send();

            $this->mailer->clearAddresses();
            $this->mailer->clearAllRecipients();
        }

        /**
         * @return bool
         */
        public function isPrepared()
        {
            return $this->isPrepared;
        }
    }
}
