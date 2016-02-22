<?php

/**
 * Copyright (c) Dean Eigenmann 2015
 * All rights reserved.
 */
 
namespace Ganked\Frontend\Routers
{

    use Ganked\Skeleton\Backends\Streams\TemplatesStreamWrapper;

    /**
     * @covers Ganked\Frontend\Routers\ErrorPageRouter
     * @uses Ganked\Skeleton\Factories\MasterFactory
     * @uses Ganked\Frontend\Factories\HandlerFactory
     * @uses Ganked\Frontend\Factories\RendererFactory
     * @uses Ganked\Frontend\Factories\LocatorFactory
     * @uses Ganked\Skeleton\Factories\AbstractFactory
     * @uses Ganked\Frontend\Factories\ControllerFactory
     * @uses Ganked\Frontend\Factories\QueryFactory
     * @uses Ganked\Skeleton\Factories\SessionFactory
     * @uses Ganked\Skeleton\Factories\BackendFactory
     * @uses Ganked\Frontend\Controllers\AbstractPageController
     * @uses \Ganked\Frontend\Renderers\StaticPageRenderer
     * @uses \Ganked\Skeleton\Models\AbstractModel
     * @uses \Ganked\Skeleton\Models\AbstractPageModel
     * @uses \Ganked\Frontend\Controllers\StaticPageController
     * @uses \Ganked\Frontend\Renderers\AppendCSRFTokenSnippetRenderer
     * @uses \Ganked\Frontend\ParameterObjects\AbstractControllerParameterObject
     * @uses \Ganked\Frontend\ParameterObjects\RedirectControllerParameterObject
     * @uses \Ganked\Frontend\Renderers\SignInLinksSnippetRenderer
     * @uses \Ganked\Frontend\Renderers\HeaderSnippetRenderer
     * @uses \Ganked\Frontend\Renderers\AbstractPageRenderer
     * @uses \Ganked\Library\ValueObjects\Token
     * @uses \Ganked\Frontend\Renderers\TrackingSnippetRenderer
     * @uses \Ganked\Skeleton\Session\Session
     * @uses \Ganked\Frontend\Locators\RendererLocator
     * @uses \Ganked\Frontend\Renderers\GenericPageRenderer
     * @uses \Ganked\Frontend\Renderers\InfoBarRenderer
     * @uses \Ganked\Frontend\ParameterObjects\ControllerParameterObject
     * @uses \Ganked\Frontend\Handlers\Get\AbstractPostHandler
     * @uses \Ganked\Frontend\Handlers\Get\AbstractResponseHandler
     */
    class ErrorPageRouterTest extends GenericRouterTestHelper
    {
        protected function setUp()
        {
            parent::setUp();
            $this->router = new ErrorPageRouter($this->masterFactory);
            TemplatesStreamWrapper::setUp(__DIR__ . '/../../../data/templates');
        }

        protected function tearDown()
        {
            TemplatesStreamWrapper::tearDown();
        }

        /**
         * @return array
         */
        public function provideInstanceNames()
        {
            return [
                ['/404', \Ganked\Frontend\Controllers\StaticPageController::class]
            ];
        }
    }
}
