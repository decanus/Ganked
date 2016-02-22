<?php

 /**
 * Copyright (c) Ganked 2015
 * All rights reserved.
 */
 
namespace Ganked\Frontend\Renderers
{
    class UserProfilePageRenderer extends AbstractPageRenderer
    {
        protected function doRender()
        {
            $this->setTitle('Profile');

            $template = $this->getTemplate();

            $box = $template->createElement('div');
            $box->setAttribute('class', 'generic-box -fit -center -small');
            $box->appendChild($template->createElement('h1', 'Under Construction'));
            $box->appendChild($template->createElement('p', 'This page is currently under construction, check back later!'));
            $template->getElementById('main')->appendChild($box);

            //@todo: open graph profile and schema.org person
        }
    }
}
