<?php

/**
 * Copyright (c) Dean Eigenmann 2015
 * All rights reserved.
 */
 
namespace Ganked\Backend\Tasks
{

    use Ganked\Library\ValueObjects\DataVersion;

    /**
     * @covers Ganked\Backend\Tasks\BuildStaticPageTask
     */
    class BuildStaticPageTaskTest extends \PHPUnit_Framework_TestCase
    {
        /**
         * @var BuildStaticPageTask
         */
        private $task;
        private $builder;
        private $staticPageWriter;
        private $fileBackend;

        protected function setUp()
        {
            $this->builder = $this->getMockBuilder(\Ganked\Backend\Builders\StaticPageBuilder::class)
                ->disableOriginalConstructor()
                ->getMock();
            $this->staticPageWriter = $this->getMockBuilder(\Ganked\Backend\Writers\StaticPageWriter::class)
                ->disableOriginalConstructor()
                ->getMock();
            $this->fileBackend = $this->getMockBuilder(\Ganked\Library\Backends\FileBackend::class)
                ->disableOriginalConstructor()
                ->getMock();

            $this->task = new BuildStaticPageTask(
                $this->builder,
                $this->staticPageWriter,
                $this->fileBackend
            );
        }

        public function testRunWorks()
        {
            $request = $this->getMockBuilder(\Ganked\Backend\Request::class)
                ->disableOriginalConstructor()
                ->getMock();

            $this->fileBackend
                ->expects($this->once())
                ->method('load')
                ->will($this->returnValue('{"/":"homepage"}'));

            $dataVersion = new DataVersion('20150909-2332');

            $request->expects($this->once())
                ->method('getParameter')
                ->with('dataVersion')
                ->will($this->returnValue((string) $dataVersion));

            $staticPage = $this->getMockBuilder(\Ganked\Backend\StaticPages\StaticPage::class)
                ->disableOriginalConstructor()
                ->getMock();

            $this->builder
                ->expects($this->once())
                ->method('build')
                ->with('/', 'homepage')
                ->will($this->returnValue($staticPage));

            $this->staticPageWriter
                ->expects($this->once())
                ->method('write')
                ->with($dataVersion, $staticPage);

            $this->task->run($request);
        }
    }
}
