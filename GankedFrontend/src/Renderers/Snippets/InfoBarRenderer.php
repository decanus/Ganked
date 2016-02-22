<?php

/**
 * Copyright (c) Ganked 2015
 * All rights reserved.
 */

namespace Ganked\Frontend\Renderers
{

    use Ganked\Library\DataPool\DataPoolReader;
    use Ganked\Library\Helpers\DomHelper;

    class InfoBarRenderer
    {
        /**
         * @var DataPoolReader
         */
        private $dataPoolReader;
        /**
         * @param DataPoolReader $dataPoolReader
         */
        public function __construct(DataPoolReader $dataPoolReader)
        {
            $this->dataPoolReader = $dataPoolReader;
        }

        /**
         * @param DomHelper $template
         * 
         * @todo try catch
         */
        public function render(DomHelper $template)
        {
            try {
                if (!$this->dataPoolReader->isInfoBarEnabled()) {
                    return;
                }

                $infoBarPlaceHolder = $template->getFirstElementByTagName('infoBar');

                if ($infoBarPlaceHolder === null) {
                    return;
                }
    
                $message = $this->dataPoolReader->getInfoBarMessage();
    
                if ($message === '' || !$message) {
                    return;
                }
    
                $infoBar = new DomHelper('<div class="page-banner">' . $message . '</div>');
                $infoBarPlaceHolder->parentNode->replaceChild($template->importNode($infoBar->documentElement, true), $infoBarPlaceHolder);
            } catch (\Exception $e) {
                return;
            }
 
        }
    }
}
