<?php

/**
 * Copyright (c) Dean Eigenmann 2015
 * All rights reserved.
 */
 
namespace Ganked\Frontend\Routers
{

    use Ganked\Skeleton\Backends\Streams\TemplatesStreamWrapper;

    /**
     * @covers Ganked\Frontend\Routers\AccountPageRouter
     * @uses Ganked\Skeleton\Factories\MasterFactory
     * @uses Ganked\Frontend\Factories\HandlerFactory
     * @uses Ganked\Frontend\Factories\RendererFactory
     * @uses Ganked\Skeleton\Factories\AbstractFactory
     * @uses Ganked\Frontend\Factories\ControllerFactory
     * @uses Ganked\Frontend\Factories\QueryFactory
     * @uses Ganked\Skeleton\Factories\SessionFactory
     * @uses Ganked\Frontend\Controllers\AbstractPageController
     * @uses Ganked\Frontend\Renderers\AbstractPageRenderer
     * @uses Ganked\Frontend\Renderers\StaticPageRenderer
     * @uses Ganked\Skeleton\Session\Session
     * @uses \Ganked\Skeleton\Models\AbstractPageModel
     * @uses \Ganked\Frontend\Models\StaticPageModel
     * @uses \Ganked\Frontend\Renderers\TrackingSnippetRenderer
     * @uses \Ganked\Library\Helpers\DomHelper
     * @uses \Ganked\Frontend\Renderers\HeaderSnippetRenderer
     * @uses \Ganked\Frontend\Renderers\AppendCSRFTokenSnippetRenderer
     * @uses \Ganked\Library\ValueObjects\Token
     * @uses \Ganked\Frontend\Renderers\SignInLinksSnippetRenderer
     * @uses \Ganked\Skeleton\Models\AbstractModel
     * @uses \Ganked\Frontend\Renderers\PasswordRecoveryPageRenderer
     * @uses \Ganked\Frontend\Controllers\PasswordRecoveryPageController
     * @uses \Ganked\Frontend\Renderers\GenericPageRenderer
     * @uses \Ganked\Frontend\Renderers\InfoBarRenderer
     * @uses \Ganked\Frontend\ParameterObjects\ControllerParameterObject
     * @uses \Ganked\Frontend\ParameterObjects\AbstractControllerParameterObject
     * @uses \Ganked\Frontend\ParameterObjects\RedirectControllerParameterObject
     * @uses \Ganked\Frontend\Handlers\Get\AbstractPostHandler
     * @uses \Ganked\Frontend\Handlers\Get\AbstractResponseHandler
     * @uses \Ganked\Frontend\Renderers\AccountPageRenderer
     * @uses \Ganked\Frontend\Handlers\Get\TransformationHandler
     * @uses \Ganked\Frontend\Handlers\Get\Account\QueryHandler
     * @uses \Ganked\Frontend\Renderers\SteamOpenIdLinkRenderer
     */
    class AccountPageRouterTest extends GenericRouterTestHelper
    {
        private $sessionData;

        protected function setUp()
        {
            parent::setUp();
            $this->sessionData = $this->getMockBuilder(\Ganked\Skeleton\Session\SessionData::class)
                ->disableOriginalConstructor()
                ->getMock();
            $this->router = new AccountPageRouter($this->masterFactory, $this->sessionData);
            TemplatesStreamWrapper::setUp(__DIR__ . '/../../../data/templates');
        }

        protected function tearDown()
        {
            TemplatesStreamWrapper::tearDown();
        }

        /**
         * @param $path
         * @param $instance
         * @dataProvider provideInstanceNames
         */
        public function testCreateRouteWorks($path, $instance)
        {
            $account = $this->getMockBuilder(\Ganked\Library\DataObjects\Accounts\RegisteredAccount::class)
                ->disableOriginalConstructor()
                ->getMock();
            $this->sessionData
                ->expects($this->any())
                ->method('getAccount')
                ->will($this->returnValue($account));

            parent::testCreateRouteWorks($path, $instance);
        }

        public function testCreateRouteWorksForRedirect()
        {
            $account = $this->getMockBuilder(\Ganked\Library\DataObjects\Accounts\AnonymousAccount::class)
                ->disableOriginalConstructor()
                ->getMock();
            $this->sessionData
                ->expects($this->any())
                ->method('getAccount')
                ->will($this->returnValue($account));

            parent::testCreateRouteWorks('/account', \Ganked\Skeleton\Controllers\GetController::class);
        }

        /**
         * @return array
         */
        public function provideInstanceNames()
        {
            return [
                ['/account', \Ganked\Skeleton\Controllers\GetController::class],
                ['/recover-password', \Ganked\Frontend\Controllers\PasswordRecoveryPageController::class],
            ];
        }
    }
}
