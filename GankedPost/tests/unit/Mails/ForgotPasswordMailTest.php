<?php

/**
 * Copyright (c) Dean Eigenmann 2015
 * All rights reserved.
 */
 
namespace Ganked\Post\Mails
{

    use Ganked\Library\Helpers\DomHelper;
    use Ganked\Library\ValueObjects\Uri;

    /**
     * @covers Ganked\Post\Mails\ForgotPasswordMail
     * @covers Ganked\Post\Mails\AbstractMail
     * @covers Ganked\Library\Helpers\DomHelper
     * @covers Ganked\Library\ValueObjects\Email
     */
    class ForgotPasswordMailTest extends \PHPUnit_Framework_TestCase
    {
        /**
         * @var ForgotPasswordMail
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
            $this->mail = new ForgotPasswordMail(false, $this->backend, $this->query, new Uri('ganked.test'));
        }
        public function testSetAndGetRecipientWorks()
        {
            $this->mail->setRecipient([]);
            $this->assertSame([], $this->mail->getRecipient());
        }

        public function testSendWorks()
        {
            $this->mail->setHash('1234');
            $this->mail->setEmail('test@ganked.net');
            $this->mail->setRecipient(['email' => 'test@ganked.net', 'name' =>  'test test']);

            $mail = new DomHelper('<html xmlns="http://www.w3.org/1999/xhtml"><body><div id="header">
<a href="http://ganked.net"><img src="//cdn.ganked.net/images/logo.png"/></a></div><p style="line-height: 20px;"><b></b>
</p><p><a href="">Login with new Password</a></p></body></html>');

            $this->query
                ->expects($this->once())
                ->method('execute')
                ->with('templates://mails/forgotPassword.xhtml')
                ->will($this->returnValue($mail));

            $this->backend
                ->expects($this->once())
                ->method('setSender');

            $this->backend
                ->expects($this->once())
                ->method('setRecipient')
                ->with(['email' => 'test@ganked.net', 'name' =>  'test test']);

            $this->backend
                ->expects($this->once())
                ->method('setSubject')
                ->with('Password Recovery - Ganked.net');

            $this->backend
                ->expects($this->once())
                ->method('send');

            $this->mail->send($this->request);
        }
    }
}
