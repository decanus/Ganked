<?php

/**
 * Copyright (c) Dean Eigenmann 2015
 * All rights reserved.
 */
 
namespace Ganked\Skeleton\Session
{

    /**
     * @covers Ganked\Skeleton\Session\Session
     * @uses Ganked\Skeleton\Session\SessionData
     * @uses Ganked\Library\ValueObjects\Token
     */
    class SessionTest extends \PHPUnit_Framework_TestCase
    {
        /**
         * @var Session
         */
        private $session;
        private $sessionDataPool;
        private $request;
        private $sessionData;

        protected function setUp()
        {
            $this->sessionDataPool = $this->getMockBuilder(\Ganked\Skeleton\Session\SessionDataPool::class)
                ->disableOriginalConstructor()
                ->getMock();
            $this->request = $this->getMockBuilder(\Ganked\Skeleton\Http\Request\PostRequest::class)
                ->disableOriginalConstructor()
                ->getMock();
            $this->sessionData = $this->getMockBuilder(\Ganked\Skeleton\Map::class)
                ->disableOriginalConstructor()
                ->getMock();
            $this->session = new Session($this->sessionDataPool);
        }

        public function testLoadAndGetSessionDataWorksWhenCookieIsSet()
        {
            $this->request
                ->expects($this->once())
                ->method('hasCookieParameter')
                ->with('SID')
                ->will($this->returnValue(true));

            $sid = '1234';
            $this->request
                ->expects($this->once())
                ->method('getCookieParameter')
                ->with('SID')
                ->will($this->returnValue($sid));

            $this->sessionDataPool
                ->expects($this->once())
                ->method('load')
                ->with($sid)
                ->will($this->returnValue($this->sessionData));

            $this->session->load($this->request);

            $this->assertInstanceOf(\Ganked\Skeleton\Session\SessionData::class, $this->session->getSessionData());
        }

        public function testLoadAndGetSessionDataWorksWhenCookieIsNotSet()
        {
            $this->request
                ->expects($this->once())
                ->method('hasCookieParameter')
                ->with('SID')
                ->will($this->returnValue(false));

            $this->request
                ->expects($this->once())
                ->method('getUserIp')
                ->will($this->returnValue('123.123.123.123'));

            $this->request
                ->expects($this->exactly(2))
                ->method('getUserAgent')
                ->will($this->returnValue('123.123.123.123'));

            $this->sessionDataPool
                ->expects($this->once())
                ->method('load')
                ->will($this->returnValue($this->sessionData));

            $this->session->load($this->request);

            $this->assertInstanceOf(\Ganked\Skeleton\Session\SessionData::class, $this->session->getSessionData());
        }

        public function testGetCookieWorks()
        {

            $this->sessionDataPool
                ->expects($this->once())
                ->method('load')
                ->will($this->returnValue($this->sessionData));

            $this->request
                ->expects($this->once())
                ->method('hasCookieParameter')
                ->with('SID')
                ->will($this->returnValue(true));

            $sid = '1234';
            $this->request
                ->expects($this->once())
                ->method('getCookieParameter')
                ->with('SID')
                ->will($this->returnValue($sid));

            $this->session->load($this->request);

            $this->assertInstanceOf(\Ganked\Library\ValueObjects\Cookie::class, $this->session->getCookie());
        }

        public function testGetTokenWorks()
        {
            $this->request
                ->expects($this->once())
                ->method('hasCookieParameter')
                ->with('SID')
                ->will($this->returnValue(true));

            $sid = '1234';
            $this->request
                ->expects($this->once())
                ->method('getCookieParameter')
                ->with('SID')
                ->will($this->returnValue($sid));

            $this->sessionDataPool
                ->expects($this->once())
                ->method('load')
                ->with($sid)
                ->will($this->returnValue($this->sessionData));

            $this->session->load($this->request);

            $this->sessionData
                ->expects($this->once())
                ->method('has')
                ->with('token')
                ->will($this->returnValue(false));

            $this->sessionData
                ->expects($this->once())
                ->method('set');

            $this->sessionData
                ->expects($this->once())
                ->method('get')
                ->with('token')
                ->will($this->returnValue('1234'));

            $this->assertInstanceOf(\Ganked\Library\ValueObjects\Token::class, $this->session->getToken());

        }

        public function testWriteWorks()
        {
            $this->request
                ->expects($this->once())
                ->method('hasCookieParameter')
                ->with('SID')
                ->will($this->returnValue(false));

            $this->request
                ->expects($this->once())
                ->method('getUserIp')
                ->will($this->returnValue('123.123.123.123'));

            $this->request
                ->expects($this->exactly(2))
                ->method('getUserAgent')
                ->will($this->returnValue('123.123.123.123'));

            $this->sessionDataPool
                ->expects($this->once())
                ->method('load')
                ->will($this->returnValue($this->sessionData));

            $this->session->load($this->request);

            $this->sessionDataPool
                ->expects($this->once())
                ->method('save');

            $this->sessionDataPool
                ->expects($this->once())
                ->method('expire');

            $this->session->write();

        }

        public function testDestroyWorks()
        {
            $this->sessionDataPool
                ->expects($this->once())
                ->method('destroy');

            $this->request
                ->expects($this->once())
                ->method('removeCookieParameter')
                ->with('SID');

            $this->request
                ->expects($this->once())
                ->method('hasCookieParameter')
                ->with('SID')
                ->will($this->returnValue(false));

            $this->request
                ->expects($this->once())
                ->method('getUserIp')
                ->will($this->returnValue('123.123.123.123'));

            $this->request
                ->expects($this->exactly(2))
                ->method('getUserAgent')
                ->will($this->returnValue('123.123.123.123'));

            $this->sessionDataPool
                ->expects($this->once())
                ->method('load')
                ->will($this->returnValue($this->sessionData));

            $this->session->destroy($this->request);
        }

        public function testIsSessionStartedReturnsExpectedValue()
        {
            $this->assertFalse($this->session->isSessionStarted());
        }

    }
}
