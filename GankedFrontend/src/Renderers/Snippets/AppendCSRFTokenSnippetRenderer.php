<?php

/**
 * Copyright (c) Dean Eigenmann 2015
 * All rights reserved.
 */
 
namespace Ganked\Frontend\Renderers
{

    use DOMNode;
    use Ganked\Skeleton\Session\Session;

    class AppendCSRFTokenSnippetRenderer extends AbstractSnippetRenderer
    {
        /**
         * @var Session
         */
        private $session;

        /**
         * @param Session $session
         */
        public function __construct(Session $session)
        {
            $this->session = $session;
        }

        protected function doRender()
        {
            $inputs = $this->getTemplate()->getElementsByTagName('input');

            /**
             * @var DomNode $input
             */
            foreach ($inputs as $input) {
                if ($input->getAttribute('name') === 'token') {
                    $input->setAttribute('value', (string) $this->session->getToken());
                }
            }
        }
    }
}
