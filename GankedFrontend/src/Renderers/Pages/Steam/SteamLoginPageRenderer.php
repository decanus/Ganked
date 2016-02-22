<?php

/**
 * Copyright (c) Ganked 2015
 * All rights reserved.
 */

namespace Ganked\Frontend\Renderers
{

    class SteamLoginPageRenderer extends AbstractPageRenderer
    {

        protected function doRender()
        {
            $template = $this->getDomFromTemplate('templates://content/steam/loginError.xhtml');
            $this->setTitle('Steam Login');
            $this->getSnippetTransformation()->appendToMain($template);
        }
    }
}
