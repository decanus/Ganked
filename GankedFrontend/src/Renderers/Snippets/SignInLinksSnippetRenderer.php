<?php

/**
 * Copyright (c) Dean Eigenmann 2015
 * All rights reserved.
 */
 
namespace Ganked\Frontend\Renderers
{

    use Ganked\Library\DataObjects\Accounts\AnonymousAccount;

    class SignInLinksSnippetRenderer extends AbstractSnippetRenderer
    {
        protected function doRender()
        {
            $template = $this->getTemplate();

            if ($this->getModel()->getAccount() instanceof AnonymousAccount) {
                return;
            }

            $signInLinks = $template->getElementById('signInLinks');

            if ($signInLinks !== null) {
                $signInLinks->parentNode->removeChild($signInLinks);
            }

            $topSignInLinks = $template->getElementById('topSignInLinks');

            if ($topSignInLinks !== null) {
                $topSignInLinks->parentNode->removeChild($topSignInLinks);
            }
        }
    }
}
