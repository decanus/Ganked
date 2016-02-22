<?php

/**
 * Copyright (c) Dean Eigenmann 2015
 * All rights reserved.
 */
 
namespace Ganked\Backend\Builders
{
    /**
     * @covers Ganked\Backend\Builders\StaticPageBuilder
     * @uses \Ganked\Backend\StaticPages\StaticPage
     */
    class StaticPageBuilderTest extends \PHPUnit_Framework_TestCase
    {
        /**
         * @var StaticPageBuilder
         */
        private $builder;

        private $fileBackend;
        private $snippetTransformation;
        private $rendererLocator;

        protected function setUp()
        {
            $this->fileBackend = $this->getMockBuilder(\Ganked\Library\Backends\FileBackend::class)
                ->disableOriginalConstructor()
                ->getMock();

            $this->snippetTransformation = $this->getMockBuilder(\Ganked\Skeleton\Transformations\SnippetTransformation::class)
                ->disableOriginalConstructor()
                ->getMock();

            $textTransformation = $this->getMockBuilder(\Ganked\Skeleton\Transformations\TextTransformation::class)
                ->disableOriginalConstructor()
                ->getMock();

            $this->rendererLocator = $this->getMockBuilder(\Ganked\Backend\Locators\RendererLocator::class)
                ->disableOriginalConstructor()
                ->getMock();

            $this->builder = new StaticPageBuilder(
                $this->fileBackend,
                $this->snippetTransformation,
                $textTransformation,
                $this->rendererLocator
            );
        }

        public function testExecuteWorks()
        {
            $uri = '/test';
            $path = 'test';

            $this->fileBackend
                ->expects($this->at(0))
                ->method('load')
                ->with('pages://content/' . $path . '/index.json')
                ->will($this->returnValue(file_get_contents(__DIR__ . '/../../data/staticPageBuilder/index.json')));

            $this->fileBackend
                ->expects($this->at(1))
                ->method('load')
                ->with('pages://template.xhtml')
                ->will($this->returnValue('<body><header/><aside/><main id="main"/></body>'));

            $this->fileBackend
                ->expects($this->at(2))
                ->method('load')
                ->with('pages://skeleton/skeleton.xhtml')
                ->will($this->returnValue('<div/>'));

            $this->assertInstanceOf(\Ganked\Backend\StaticPages\StaticPage::class, $this->builder->build($uri, $path));
        }

        /**
         * @expectedException \Exception
         */
        public function testEmptyContentSetsException()
        {
            $uri = '/test';
            $path = 'test';

            $this->fileBackend
                ->expects($this->at(0))
                ->method('load')
                ->with('pages://content/' . $path . '/index.json')
                ->will($this->returnValue(json_encode(['requiresOffline' => false, 'requiresOnline' => false, 'meta' => []])));

            $this->fileBackend
                ->expects($this->at(1))
                ->method('load')
                ->with('pages://template.xhtml')
                ->will($this->returnValue('<body/>'));

            $this->builder->build($uri, $path);
        }
    }
}
