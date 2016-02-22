<?php

/**
 * Copyright (c) Dean Eigenmann 2015
 * All rights reserved.
 */
 
namespace Ganked\Backend\Writers
{

    use Ganked\Backend\StaticPages\StaticPage;
    use Ganked\Library\DataPool\AbstractDataPool;
    use Ganked\Library\ValueObjects\DataVersion;

    class StaticPageWriter extends AbstractDataPool
    {
        /**
         * @param DataVersion $dataVersion
         * @param StaticPage  $staticPage
         */
        public function write(DataVersion $dataVersion, StaticPage $staticPage)
        {
            $page['sp_' . $staticPage->getUri()] = $staticPage->getTemplate()->saveXML();
            $page['meta_' . $staticPage->getUri()] = serialize($staticPage->getMetaTags());
            $page['bodyClass_' . $staticPage->getUri()] = $staticPage->getBodyClass();

            $this->getBackend()->hMSet((string) $dataVersion, $page);
        }
    }
}
