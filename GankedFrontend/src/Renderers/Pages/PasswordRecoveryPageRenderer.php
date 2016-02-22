<?php

 /**
 * Copyright (c) Ganked 2015
 * All rights reserved.
 */
 
namespace Ganked\Frontend\Renderers
{

    use Ganked\Frontend\Models\PasswordRecoveryPageModel;
    use Ganked\Library\Backends\DomBackend;
    use Ganked\Library\Helpers\DomHelper;
    use Ganked\Skeleton\Renderers\XslRenderer;
    use Ganked\Skeleton\Transformations\SnippetTransformation;
    use Ganked\Skeleton\Transformations\TextTransformation;

    class PasswordRecoveryPageRenderer extends AbstractPageRenderer
    {
        /**
         * @var XslRenderer
         */
        private $xslRenderer;

        /**
         * @param DomBackend            $domBackend
         * @param DomHelper             $template
         * @param SnippetTransformation $snippetTransformation
         * @param TextTransformation    $textTransformation
         * @param GenericPageRenderer   $genericPageRenderer
         * @param XslRenderer           $xslRenderer
         */
        public function __construct(
            DomBackend $domBackend,
            DomHelper $template,
            SnippetTransformation $snippetTransformation,
            TextTransformation $textTransformation,
            GenericPageRenderer $genericPageRenderer,
            XslRenderer $xslRenderer
        )
        {
            parent::__construct(
                $domBackend,
                $template,
                $snippetTransformation,
                $textTransformation,
                $genericPageRenderer

            );

            $this->xslRenderer = $xslRenderer;
        }

        protected function doRender()
        {
            $main = $this->getTemplate()->getFirstElementByTagName('main');
            $main->setAttribute('class', 'wrap tac');

            /**
             * @var $model PasswordRecoveryPageModel
             */
            $model = $this->getModel();
            $this->setTitle('Forgot Password?');

            $doc = new DomHelper(
                '<doc email="' . $model->getEmail() . '" hash="' .  $model->getHash() .  '" isValidHash="' . $this->getStringFromBool($model->isHashValid()) . '" />'
            );

            $this->getSnippetTransformation()->appendToMain($this->xslRenderer->render('templates://xsl/account/forgotPasswordPage.xsl', $doc));

        }
    }
}
