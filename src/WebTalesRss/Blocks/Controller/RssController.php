<?php

namespace WebTalesRss\Blocks\Controller;

use Rubedo\Blocks\Controller\AbstractController;
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
    public function init() {
        parent::init();
        $this->blockConfig = $this->getParamFromQuery('block-config', array());
    }

    public function indexAction() {
        $this->init();
        //var_dump($this->blockConfig);

        //$channel = Reader::import('http://rss.example.com/channelName');
    }

}