<?php

/**
 * Copyright (c) Dean Eigenmann 2015
 * All rights reserved.
 */
 
namespace Ganked\Frontend\Renderers
{

    use Ganked\Library\Helpers\DomHelper;
    use Ganked\Library\ValueObjects\Token;

    /**
     * @covers Ganked\Frontend\Renderers\AppendCSRFTokenSnippetRenderer
     * @covers \Ganked\Frontend\Renderers\AbstractSnippetRenderer
     * @uses \Ganked\Library\Helpers\DomHelper
     */
    class AppendCSRFTokenSnippetRendererTest extends \PHPUnit_Framework_TestCase
    {
        /**
         * @var AppendCSRFTokenSnippetRenderer
         */
        private $renderer;

        /**
         * @var DomHelper
         */
        private $template;

        private $session;

        private $model;

        protected function setUp()
        {
            $this->template = new DomHelper('<div><input name="email" /><input name="token" /></div>');
            $this->model = $this->getMockBuilder(\Ganked\Frontend\Models\StaticPageModel::class)
                ->disableOriginalConstructor()
                ->getMock();
            $this->session = $this->getMockBuilder(\Ganked\Skeleton\Session\Session::class)
                ->disableOriginalConstructor()
                ->getMock();

            $this->renderer = new AppendCSRFTokenSnippetRenderer($this->session);
        }

        public function testRendererAppendsToken()
        {
            $this->session
                ->expects($this->once())
                ->method('getToken')
                ->will($this->returnValue(new Token('1234')));

            $this->renderer->render($this->model, $this->template);
            $this->assertXmlStringEqualsXmlString(
                '<div><input name="email" /><input name="token" value="1234"/></div>',
                $this->template->saveXML()
            );
        }
    }
}
