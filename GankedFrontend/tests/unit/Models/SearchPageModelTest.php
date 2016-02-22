<?php

/**
 * Copyright (c) Dean Eigenmann 2015
 * All rights reserved.
 */
 
namespace Ganked\Frontend\unit\Models
{

    use Ganked\Frontend\Models\SearchPageModel;

    /**
     * @covers Ganked\Frontend\Models\SearchPageModel
     * @covers \Ganked\Skeleton\Models\AbstractPageModel
     * @covers \Ganked\Skeleton\Models\AbstractModel
     */
    class SearchPageModelTest extends \PHPUnit_Framework_TestCase
    {
        /**
         * @var SearchPageModel
         */
        private $model;

        private $uri;

        protected function setUp()
        {
            $this->uri = $this->getMockBuilder(\Ganked\Library\ValueObjects\Uri::class)
                ->disableOriginalConstructor()
                ->getMock();
            $this->model = new SearchPageModel($this->uri);
        }

        public function testSetAndGetSearchResultsWorks()
        {
            $results = array('a');
            $this->model->setSearchResult($results);
            $this->assertSame($results, $this->model->getSearchResult());
        }

        public function testSetGetAndHasRedirectUriWorks()
        {
            $this->assertFalse($this->model->hasRedirectUri());
            $this->model->setRedirectUri($this->uri);
            $this->assertSame($this->uri, $this->model->getRedirectUri());
            $this->assertTrue($this->model->hasRedirectUri());
        }
    }
}
