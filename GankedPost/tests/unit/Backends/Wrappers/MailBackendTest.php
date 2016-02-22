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

    /**
     * @covers Ganked\Post\Backends\MailBackend
     * @uses Ganked\Library\ValueObjects\Email
     * @uses \Ganked\Library\Helpers\DomHelper
     * @uses PHPMailer
     */
    class MailBackendTest extends \PHPUnit_Framework_TestCase
    {
        /**
         * @var MailBackend
         */
        private $backend;

        private $mailerService;

        protected function setUp()
        {
            $this->mailerService = $this->getMockBuilder(PHPMailer::class)->disableOriginalConstructor()->getMock();
            $this->backend = new MailBackend('smtp.ganked.net', 'email@ganked.net', 'password', $this->mailerService);
        }

        public function testSetSenderWorks()
        {
            $this->mailerService
                ->expects($this->once())
                ->method('setFrom')
                ->with('test@ganked.net', 'Test Ganked');

            $this->backend->setSender(new Email('test@ganked.net'), 'Test Ganked');
        }

        public function testSetRecipientsWorks()
        {
            $this->mailerService
                ->expects($this->once())
                ->method('addAddress')
                ->with('hansi@icloud.com', 'Hansi');

            $this->backend->setRecipients([['email' => 'hansi@icloud.com', 'name' => 'Hansi']]);
        }

        public function testSendWorks()
        {
            $this->mailerService
                ->expects($this->once())
                ->method('isSMTP');

            $this->mailerService
                ->expects($this->once())
                ->method('send');

            $this->mailerService
                ->expects($this->once())
                ->method('clearAddresses');

            $this->mailerService
                ->expects($this->once())
                ->method('clearAllRecipients');

            $this->backend->send();
        }

        public function testSetRecipientWorks()
        {
            $recipient = ['email' => 'test@ganked.net', 'name' => 'bro'];
            $this->mailerService
                ->expects($this->once())
                ->method('addAddress')
                ->with($recipient['email'], $recipient['name']);

            $this->backend->setRecipient($recipient);
        }

        public function testSetHTMLBodyWorks()
        {
            $htmlBody = new DomHelper('<div></div>');
            $this->mailerService
                ->expects($this->once())
                ->method('msgHTML')
                ->with($htmlBody->saveXML());

            $this->backend->setHTMLBody($htmlBody);
        }

        public function testSetSubjectWorks()
        {
            $this->backend->setSubject('test');
            $this->assertSame('test', $this->mailerService->Subject);
        }

    }
}
