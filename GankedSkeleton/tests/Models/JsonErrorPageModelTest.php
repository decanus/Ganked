<?php
 /**
 * Copyright (c) Dean Eigenmann 2015
 * All rights reserved.
 */

namespace Ganked\Skeleton\Models
{

    use Ganked\Library\ValueObjects\MetaTags;

    /**
     * @covers Ganked\Skeleton\Models\JsonErrorPageModel
     * @covers Ganked\Skeleton\Models\AbstractPageModel
     * @covers Ganked\Skeleton\Models\AbstractModel
     */
    class JsonErrorPageModelTest extends \PHPUnit_Framework_TestCase
    {
        /**
         * @var JsonErrorPageModel
         */
        private $model;
        private $uri;

        protected function setUp()
        {
            $this->uri = $this->getMockBuilder(\Ganked\Library\ValueObjects\Uri::class)
                ->disableOriginalConstructor()
                ->getMock();

            $this->model = new JsonErrorPageModel($this->uri);
        }

        public function testRequestUriCanBeRetrieved()
        {
            $this->assertSame($this->uri, $this->model->getRequestUri());
        }

        public function testRedirectUriCanBeSetAndRetrieved()
        {
            $this->model->setRedirectUri($this->uri);
            $this->assertSame($this->uri, $this->model->getRedirectUri());
        }

        public function testHasRedirectUriReturnsTrueWhenUriIsAdded()
        {
            $this->assertFalse($this->model->hasRedirectUri());
            $this->model->setRedirectUri($this->uri);
            $this->assertTrue($this->model->hasRedirectUri());
        }

        public function testStatusCodeCanBeSetAndRetrieved()
        {
            $code = 404;
            $this->model->setResponseCode($code);
            $this->assertSame($code, $this->model->getResponseCode());
        }

        public function testMetaTagsCanBeSetAndRetrieved()
        {
            $tags = new MetaTags;
            $this->model->setMetaTags($tags);
            $this->assertSame($tags, $this->model->getMetaTags());
        }

        public function testContentCanBeSetAndRetrieved()
        {
            $content = [];
            $this->model->setContent([]);
            $this->assertSame($content, $this->model->getContent());
        }

    }
}
