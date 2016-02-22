<?php

/**
 * Copyright (c) Dean Eigenmann 2015
 * All rights reserved.
 */
 
namespace Ganked\Post\Mails
{

    use Ganked\Library\Helpers\DomHelper;

    /**
     * @covers Ganked\Post\Mails\VerifyMail
     * @covers Ganked\Post\Mails\AbstractMail
     * @uses Ganked\Library\ValueObjects\Email
     * @uses \Ganked\Library\Helpers\DomHelper
     */
    class VerifyMailTest extends \PHPUnit_Framework_TestCase
    {
        /**
         * @var VerifyMail
         */
        private $mail;
        private $backend;
        private $query;
        private $request;

        protected function setUp()
        {
            $this->backend = $this->getMockBuilder(\Ganked\Post\Backends\MailBackend::class)
                ->disableOriginalConstructor()
                ->getMock();
            $this->query = $this->getMockBuilder(\Ganked\Skeleton\Queries\GetDomFromFileQuery::class)
                ->disableOriginalConstructor()
                ->getMock();
            $this->request = $this->getMockBuilder(\Ganked\Skeleton\Http\Request\GetRequest::class)
                ->disableOriginalConstructor()
                ->getMock();

            $this->mail = new VerifyMail(true, $this->backend, $this->query);
        }

        public function testSetAndGetRecipientWorks()
        {
            $this->mail->setRecipient([]);
            $this->assertSame([], $this->mail->getRecipient());
        }

        public function testSendWorks()
        {
            $this->mail->setHash('1234');
            $this->mail->setRecipient(['email' => 'test@ganked.net', 'name' => 'test test']);

            $mail = new DomHelper('<html xmlns="http://www.w3.org/1999/xhtml">
                            <body><div id="header"><a href="#"><img src="//cdn.ganked.net/images/logo.png" alt="Ganked"/></a>
                        </div><div id="wrapper"><h1>Hey There</h1><p><a href="#">Verify Email</a></p></div>
                    </body></html>');

            $this->query
                ->expects($this->once())
                ->method('execute')
                ->with('templates://mails/verifyMail.xhtml')
                ->will($this->returnValue($mail));

            $this->backend
                ->expects($this->once())
                ->method('setSender');

            $this->backend
                ->expects($this->once())
                ->method('setRecipient')
                ->with(['email' => 'test@ganked.net', 'name' => 'test test']);

            $this->backend
                ->expects($this->once())
                ->method('setSubject')
                ->with('Verification - Ganked.net');

            $this->backend
                ->expects($this->once())
                ->method('send');

            $this->mail->send($this->request);
        }
    }
}
