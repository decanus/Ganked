<?php

/**
 * Copyright (c) Ganked 2015
 * All rights reserved.
 */

namespace Ganked\Frontend\Renderers
{

    use Ganked\Library\Helpers\DomHelper;
    use Ganked\Skeleton\Models\AbstractPageModel;

    class GenericPageRenderer
    {
        /**
         * @var SignInLinksSnippetRenderer
         */
        private $signInLinksSnippetRenderer;

        /**
         * @var MetaTagsSnippetsRenderer
         */
        private $metaTagsSnippetsRenderer;

        /**
         * @var TrackingSnippetRenderer
         */
        private $trackingSnippetRenderer;

        /**
         * @var HeaderSnippetRenderer
         */
        private $headerSnippetRenderer;

        /**
         * @var AppendCSRFTokenSnippetRenderer
         */
        private $appendCSRFTokenSnippetRenderer;

        /**
         * @var InfoBarRenderer
         */
        private $infoBarRenderer;

        /**
         * @param SignInLinksSnippetRenderer     $signInLinksSnippetRenderer
         * @param MetaTagsSnippetsRenderer       $metaTagsSnippetsRenderer
         * @param TrackingSnippetRenderer        $trackingSnippetRenderer
         * @param HeaderSnippetRenderer          $headerSnippetRenderer
         * @param AppendCSRFTokenSnippetRenderer $appendCSRFTokenSnippetRenderer
         * @param InfoBarRenderer                $infoBarRenderer
         */
        public function __construct(
            SignInLinksSnippetRenderer $signInLinksSnippetRenderer,
            MetaTagsSnippetsRenderer $metaTagsSnippetsRenderer,
            TrackingSnippetRenderer $trackingSnippetRenderer,
            HeaderSnippetRenderer $headerSnippetRenderer,
            AppendCSRFTokenSnippetRenderer $appendCSRFTokenSnippetRenderer,
            InfoBarRenderer $infoBarRenderer
        )
        {
            $this->signInLinksSnippetRenderer = $signInLinksSnippetRenderer;
            $this->metaTagsSnippetsRenderer = $metaTagsSnippetsRenderer;
            $this->trackingSnippetRenderer = $trackingSnippetRenderer;
            $this->headerSnippetRenderer = $headerSnippetRenderer;
            $this->appendCSRFTokenSnippetRenderer = $appendCSRFTokenSnippetRenderer;
            $this->infoBarRenderer = $infoBarRenderer;
        }

        /**
         * @param AbstractPageModel $model
         * @param DomHelper         $template
         */
        public function render(AbstractPageModel $model, DomHelper $template)
        {
            $this->signInLinksSnippetRenderer->render($model, $template);
            $this->metaTagsSnippetsRenderer->render($model, $template);
            $this->headerSnippetRenderer->render($model, $template);
            $this->trackingSnippetRenderer->render($model, $template);
            $this->appendCSRFTokenSnippetRenderer->render($model, $template);
            $this->infoBarRenderer->render($template);
        }
    }
}
