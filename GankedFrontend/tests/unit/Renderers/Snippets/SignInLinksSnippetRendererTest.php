<?php

/**
 * Copyright (c) Dean Eigenmann 2015
 * All rights reserved.
 */
 
namespace Ganked\Frontend\Renderers
{

    use Ganked\Library\Helpers\DomHelper;

    /**
     * @covers Ganked\Frontend\Renderers\SignInLinksSnippetRenderer
     * @covers \Ganked\Frontend\Renderers\AbstractSnippetRenderer
     * @uses \Ganked\Library\Helpers\DomHelper
     */
    class SignInLinksSnippetRendererTest extends \PHPUnit_Framework_TestCase
    {
        /**
         * @var SignInLinksSnippetRenderer
         */
        private $renderer;

        /**
         * @var DomHelper
         */
        private $template;
        private $model;

        protected function setUp()
        {
            $this->model = $this->getMockBuilder(\Ganked\Frontend\Models\StaticPageModel::class)
                ->disableOriginalConstructor()
                ->getMock();
            $this->template = new DomHelper;

            $this->renderer = new SignInLinksSnippetRenderer();
        }

        public function testRendererRemovesSignInLinksWhenLoggedIn()
        {
            $account = $this->getMockBuilder(\Ganked\Library\DataObjects\Accounts\RegisteredAccount::class)
                ->disableOriginalConstructor()
                ->getMock();

            $this->model
                ->expects($this->once())
                ->method('getAccount')
                ->will($this->returnValue($account));

            $this->template->loadXML('<div><div id="topSignInLinks"></div><div id="signInLinks"></div></div>');

            $this->renderer->render($this->model, $this->template);
            $this->assertXmlStringEqualsXmlString(
                '<div></div>',
                $this->template->saveXML()
            );
        }
    }
}
