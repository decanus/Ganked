<?php

/**
 * Copyright (c) Dean Eigenmann 2015
 * All rights reserved.
 */
 
namespace Ganked\Library\ValueObjects
{
    /**
     * @covers Ganked\Library\ValueObjects\MetaTags
     */
    class MetaTagsTest extends \PHPUnit_Framework_TestCase
    {
        /**
         * @var MetaTags
         */
        private $metaTags;

        protected function setUp()
        {
            $this->metaTags = new MetaTags;
        }

        public function testSetAndGetImageWorks()
        {
            $image = 'test.png';
            $this->metaTags->setImage($image);
            $this->assertSame($image, $this->metaTags->getImage());
        }

        public function testSetAndGetTitleWorks()
        {
            $title = 'title';
            $this->metaTags->setTitle($title);
            $this->assertSame($title, $this->metaTags->getTitle());
        }

        public function testSetAndGetDescriptionWorks()
        {
            $description = 'Description bro';
            $this->metaTags->setDescription($description);
            $this->assertSame($description, $this->metaTags->getDescription());
        }
    }
}
