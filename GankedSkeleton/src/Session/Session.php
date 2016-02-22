<?php

/**
 * Copyright (c) Dean Eigenmann 2015
 * All rights reserved.
 */
 
namespace Ganked\Skeleton\Session
{

    use Ganked\Library\ValueObjects\Cookie;
    use Ganked\Library\ValueObjects\Token;
    use Ganked\Skeleton\Http\Request\AbstractRequest;

    class Session
    {
        /**
         * @var SessionDataPool
         */
        private $sessionDataPool;

        /**
         * @var string
         */
        private $id;

        /**
         * @var int
         */
        private $expires = 2592000;

        /**
         * @var SessionData
         */
        private $data;

        /**
         * @var bool
         */
        private $isSessionStarted = false;

        /**
         * @var string
         */
        private $userAgent = '';

        /**
         * @param SessionDataPool $sessionDataPool
         */
        public function __construct(SessionDataPool $sessionDataPool)
        {
            $this->sessionDataPool = $sessionDataPool;
        }

        /**
         * @param AbstractRequest $request
         */
        public function load(AbstractRequest $request)
        {
            $this->setId($request);
            $this->data = new SessionData($this->sessionDataPool->load($this->id));
        }

        /**
         * @param AbstractRequest $request
         *
         * @throws \Exception
         */
        private function setId(AbstractRequest $request)
        {
            if ($request->hasCookieParameter('SID')) {
                $this->id = $request->getCookieParameter('SID');
                $this->isSessionStarted = true;
                return;
            }

            $this->userAgent = $request->getUserAgent();
            $this->id = $this->generateId($request);
        }

        /**
         * @param AbstractRequest $request
         *
         * @return string
         */
        private function generateId(AbstractRequest $request)
        {
            return md5($request->getUserIP() . $request->getUserAgent() . time());
        }

        /**
         * @return SessionData
         */
        public function getSessionData()
        {
            return $this->data;
        }

        /**
         * @return Token
         * @throws \Ganked\Skeleton\Exceptions\MapException
         */
        public function getToken()
        {
            if (!$this->data->getMap()->has('token')) {
                $this->data->getMap()->set('token', (string) new Token());
            }

            return $this->data->getToken();
        }

        /**
         * @return Cookie
         */
        public function getCookie()
        {
            return new Cookie('SID', $this->id, '/', time() + $this->expires, '.ganked.net', true, true);
        }

        /**
         * @param AbstractRequest $request
         */
        public function destroy(AbstractRequest $request)
        {
            $this->sessionDataPool->destroy($this->id);
            $this->isSessionStarted = false;
            $request->removeCookieParameter('SID');
            $this->load($request);
        }

        /**
         * @return bool
         */
        public function isSessionStarted()
        {
            return $this->isSessionStarted;
        }

        public function write()
        {
            if ($this->userAgent === 'Mozilla/5.0 (compatible; Googlebot/2.1; +http://www.google.com/bot.html)') {
                return;
            }

            if ($this->userAgent === 'Mozilla/5.0 (iPhone; CPU iPhone OS 8_3 like Mac OS X) AppleWebKit/600.1.4 (KHTML, like Gecko) Version/8.0 Mobile/12F70 Safari/600.1.4 (compatible; Googlebot/2.1; +http://www.google.com/bot.html)') {
                return;
            }

            if ($this->userAgent === 'Mozilla/5.0 (compatible; YandexBot/3.0; +http://yandex.com/bots)') {
                return;
            }

            $this->sessionDataPool->save($this->id, $this->data->getMap());

            if (!$this->isSessionStarted()) {
                $this->sessionDataPool->expire($this->id, $this->expires);
            }

        }
    }
}
