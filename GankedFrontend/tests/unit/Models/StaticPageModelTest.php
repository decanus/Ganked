<?php

/**
 * Copyright (c) Dean Eigenmann 2015
 * All rights reserved.
 */
 
namespace Ganked\Frontend\Models
{

    use Ganked\Library\Helpers\DomHelper;
    use Ganked\Library\ValueObjects\MetaTags;

    /**
     * @covers Ganked\Frontend\Models\StaticPageModel
     * @covers \Ganked\Skeleton\Models\AbstractPageModel
     * @covers \Ganked\Skeleton\Models\AbstractModel
     */
    class StaticPageModelTest extends \PHPUnit_Framework_TestCase
    {
        /**
         * @var StaticPageModel
         */
        private $model;

        private $uri;
        private $templatePath;

        protected function setUp()
        {
            $this->uri = $this->getMockBuilder(\Ganked\Library\ValueObjects\Uri::class)
                ->disableOriginalConstructor()
                ->getMock();
            $this->templatePath = 'test';
            $this->model = new StaticPageModel($this->uri, $this->templatePath);
        }

        public function testGetUriWorks()
        {
            $this->assertSame($this->uri, $this->model->getRequestUri());
        }

        public function testSetAndGetResponseCodeWorks()
        {
            $responseCode = 200;
            $this->model->setResponseCode($responseCode);
            $this->assertSame($responseCode, $this->model->getResponseCode());
        }

        public function testSetAndGetMetaTagsWorks()
        {
            $metaTags = new MetaTags;
            $this->model->setMetaTags($metaTags);
            $this->assertSame($metaTags, $this->model->getMetaTags());
        }

        public function testSetAndGetTemplateWorks()
        {
            $template = new DomHelper;
            $this->model->setTemplate($template);
            $this->assertSame($template, $this->model->getTemplate());
        }
    }
}
