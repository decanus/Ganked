<?php

/**
 * Copyright (c) Dean Eigenmann 2015
 * All rights reserved.
 */
 
namespace Ganked\Post\Mails
{

    use Ganked\Library\Helpers\DomHelper;
    use Ganked\Library\ValueObjects\Email;
    use Ganked\Post\Backends\MailBackend;
    use Ganked\Skeleton\Queries\GetDomFromFileQuery;

    abstract class AbstractMail
    {
        /**
         * @var MailBackend
         */
        private $backend;

        /**
         * @var string
         */
        private $subject;

        /**
         * @var array
         */
        private $recipient;

        /**
         * @var GetDomFromFileQuery
         */
        private $getDomFromFileQuery;

        /**
         * @var bool
         */
        private $isDevelopmentMode;

        /**
         * @param bool $isDevelopmentMode
         * @param MailBackend $backend
         * @param GetDomFromFileQuery $getDomFromFileQuery
         */
        public function __construct(
            $isDevelopmentMode = false,
            MailBackend $backend,
            GetDomFromFileQuery $getDomFromFileQuery
        )
        {
            $this->isDevelopmentMode = $isDevelopmentMode;
            $this->backend = $backend;
            $this->getDomFromFileQuery = $getDomFromFileQuery;
        }

        public function send()
        {
            $this->backend->setSender(new Email('no-reply@ganked.net'));
            $this->backend->setRecipient($this->recipient);
            $this->backend->setHTMLBody($this->render());
            $this->backend->setSubject($this->getSubject());
            $this->backend->send();
        }

        /**
         * @return DomHelper
         */
        abstract protected function render();

        /**
         * @return string
         */
        protected function getSubject()
        {
            return $this->subject;
        }

        /**
         * @param string $subject
         */
        protected function setSubject($subject)
        {
            $this->subject = $subject;
        }

        /**
         * @param array $recipient
         */
        public function setRecipient($recipient)
        {
            $this->recipient = $recipient;
        }

        /**
         * @return array
         */
        public function getRecipient()
        {
            return $this->recipient;
        }

        /**
         * @param $template
         *
         * @return DomHelper
         */
        protected function getMailTemplate($template)
        {
            return $this->getDomFromFileQuery->execute($template);
        }

        /**
         * @return bool
         */
        protected function isDevelopmentMode()
        {
            return $this->isDevelopmentMode;
        }

    }
}
