<?php

/**
 * Copyright (c) Dean Eigenmann 2015
 * All rights reserved.
 */
 
namespace Ganked\Backend\Writers
{

    use Ganked\Backend\StaticPages\StaticPage;
    use Ganked\Library\Helpers\DomHelper;
    use Ganked\Library\ValueObjects\DataVersion;
    use Ganked\Library\ValueObjects\MetaTags;

    /**
     * @covers Ganked\Backend\Writers\StaticPageWriter
     * @uses \Ganked\Backend\StaticPages\StaticPage
     */
    class StaticPageWriterTest extends \PHPUnit_Framework_TestCase
    {
        /**
         * @var StaticPageWriter
         */
        private $staticPageWriter;

        private $storage;
        protected function setUp()
        {
            $this->storage = $this->getMockBuilder(\Ganked\Library\DataPool\StorageInterface::class)
                ->disableOriginalConstructor()
                ->getMock();

            $this->staticPageWriter = new StaticPageWriter($this->storage);
        }

        public function testWriteWorks()
        {
            $uri = '/foo';
            $meta = new MetaTags;
            $template = new DomHelper('<foo />');
            $page = new StaticPage($uri, $meta, $template);
            $dataVersion = new DataVersion('now');

            $this->storage
                ->expects($this->once())
                ->method('hMSet')
                ->with(
                    (string) $dataVersion,
                    [
                        'sp_' . $uri => $template->saveXML(),
                        'meta_' . $uri => serialize($meta),
                        'bodyClass_' . $uri => '',
                    ]
                );

            $this->staticPageWriter->write($dataVersion, $page);
        }
    }
}
