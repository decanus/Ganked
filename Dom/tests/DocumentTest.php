<?php
/**
 * Copyright (c) Ganked 2015
 * All rights reserved.
 */

namespace Dom
{

    class DocumentTest extends \PHPUnit_Framework_TestCase
    {
        /**
         * @var Document
         */
        private $document;

        protected function setUp()
        {
            $this->document = new Document;
        }

        public function testGetXPathReturnsInstanceOfXPath()
        {
            $this->assertInstanceOf(\Dom\Xpath::class, $this->document->getXPath());
        }
    }
}
