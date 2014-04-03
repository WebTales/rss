<?php

namespace WebTalesRss\Blocks\Controller;

use Rubedo\Blocks\Controller\AbstractController;
use Rubedo\Services\Manager;
use Zend\Feed\Reader\Reader;

/**
 *
 * @author gdemette
 * @package Rubedo
 * @category Rubedo
 */
class RssController extends AbstractController
{
    protected $blockConfig;
    /**
     * @var \Rubedo\Interfaces\Templates\IFrontOfficeTemplates
     */
    protected $frontOfficeService;
    public function init() {
        parent::init();
        $this->blockConfig = $this->getParamFromQuery('block-config', array());
        $this->frontOfficeService = Manager::getService('FrontOfficeTemplates');
    }

    public function indexAction() {
        $this->init();

        $output = array();
        $css = array();
        $js = array();

        try {
            $channel = Reader::import($this->blockConfig['url']);
        } catch (\Exception $e) {
            $output['error'] = "webtales.block.rss.error.notContactable";
            $template = $this->frontOfficeService->getFileThemePath("@Rss/blocks/genericError.html.twig");
            return $this->_sendResponse($output, $template, $css, $js);
        }

        $output['feed'] = $channel;
        $output['blockConfig'] = $this->blockConfig;

        $template = $this->frontOfficeService->getFileThemePath("@Rss/blocks/rss.html.twig");

        return $this->_sendResponse($output, $template, $css, $js);

    }

}