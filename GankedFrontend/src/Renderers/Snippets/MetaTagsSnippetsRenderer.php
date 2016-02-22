<?php

/**
 * Copyright (c) Dean Eigenmann 2015
 * All rights reserved.
 */
 
namespace Ganked\Frontend\Renderers
{
    class MetaTagsSnippetsRenderer extends AbstractSnippetRenderer
    {
        protected function doRender()
        {
            if ($this->getModel()->getMetaTags() !== null) {
                $this->renderOpenGraphTags();
                $this->renderMetaTags();
            }
        }

        private function renderOpenGraphTags()
        {
            $template = $this->getTemplate();
            $head = $template->getFirstElementByTagName('head');

            $metaTags = $this->getModel()->getMetaTags();

            $description = $template->createElement('meta');
            $description->setAttribute('property', 'og:description');
            $description->setAttribute('content', $metaTags->getDescription());
            $head->appendChild($description);

            $title = $template->createElement('meta');
            $title->setAttribute('property', 'og:title');
            $title->setAttribute('content', $metaTags->getTitle() . ' - Ganked.net');
            $head->appendChild($title);

            $imagePath = $metaTags->getImage();
            if ($imagePath !== '') {
                $this->getTemplate()->getElementById('ogImage')->setAttribute('content', $imagePath);
            }
        }

        private function renderMetaTags()
        {
            $template = $this->getTemplate();
            $head = $template->getFirstElementByTagName('head');

            $metaTags = $this->getModel()->getMetaTags();

            $description = $template->createElement('meta');
            $description->setAttribute('name', 'description');
            $description->setAttribute('content', $metaTags->getDescription());
            $head->appendChild($description);

        }
    }
}
