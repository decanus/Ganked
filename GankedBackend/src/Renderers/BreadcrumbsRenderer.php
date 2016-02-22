<?php

/**
 * Copyright (c) Ganked 2015
 * All rights reserved.
 */
 
namespace Ganked\Backend\Renderers
{

    use Ganked\Library\Helpers\DomHelper;

    class BreadcrumbsRenderer
    {
        /**
         * @param array $breadcrumbs
         *
         * @return DomHelper
         * @throws \InvalidArgumentException
         */
        public function render(array $breadcrumbs)
        {
            if (empty($breadcrumbs)) {
                throw new \InvalidArgumentException('Breadcrumbs cannot be empty');
            }

            $listElements = [];

            foreach ($breadcrumbs as $position => $breadcrumb) {
                $listElements[] = [
                    '@type' => 'ListItem',
                    'position' => $position + 1,
                    'item' => [ '@id' => 'http://www.ganked.net' . $breadcrumb['uri'], 'name' => $breadcrumb['name']],
                ];
            }

            $json = json_encode(
                ['@context' => 'http://schema.org', '@type' => 'BreadcrumbList', 'itemListElement' => $listElements]
            );

            return new DomHelper('<script type="application/ld+json">' . $json . '</script>');
        }
    }
}
