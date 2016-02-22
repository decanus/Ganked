<?php

/**
 * Copyright (c) Dean Eigenmann 2015
 * All rights reserved.
 */

namespace Ganked\Services\Backends
{

    use Ganked\Library\ValueObjects\Uri;

    /**
     * @covers Ganked\Services\Backends\SlackBackend
     */
    class SlackBackendTest extends \PHPUnit_Framework_TestCase
    {
        /**
         * @var SlackBackend
         */
        private $slackBackend;
        private $curl;
        private $url;
        private $token;

        protected function setUp()
        {
            $this->curl = $this->getMockBuilder(\Ganked\Skeleton\Backends\Wrappers\Curl::class)
                ->disableOriginalConstructor()
                ->getMock();

            $this->url = new Uri('slack.test');

            $this->token = '1234';

            $this->slackBackend = new SlackBackend($this->token, $this->curl, $this->url);
        }

        public function testSendMessageWorks()
        {
            $this->curl
                ->expects($this->once())
                ->method('get')
                ->will($this->returnSelf());

            $this->curl
                ->expects($this->once())
                ->method('execute');

            $this->slackBackend->sendMessage('foo', 'bar');
        }

    }
}
