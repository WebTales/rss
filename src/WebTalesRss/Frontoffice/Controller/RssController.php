<?php
/**
 * Rubedo -- ECM solution
 * Copyright (c) 2013, WebTales (http://www.webtales.fr/).
 * All rights reserved.
 * licensing@webtales.fr
 *
 * Open Source License
 * ------------------------------------------------------------------------------------------
 * Rubedo is licensed under the terms of the Open Source GPL 3.0 license.
 *
 * @category   Rubedo
 * @package    Rubedo
 * @copyright  Copyright (c) 2012-2013 WebTales (http://www.webtales.fr)
 * @license    http://www.gnu.org/licenses/gpl.html Open Source GPL 3.0 license
 */

namespace WebTalesRss\Frontoffice\Controller;

use Rubedo\Services\Manager;
use Zend\Feed\Writer\Feed;
use Zend\Mvc\Controller\AbstractActionController;

class RssController extends AbstractActionController
{
    /**
     * @var $queryService \Rubedo\Interfaces\Collection\IQueries
     */
    protected $queriesService;

    /**
     * @var $contentsService \Rubedo\Interfaces\Collection\IContents
     */
    protected $contentsService;

    /**
     * @var $contentsTypeService \Rubedo\Interfaces\Collection\IContentTypes
     */
    protected $contentTypeService;

    /**
     * @var $urlService \Rubedo\Interfaces\Router\IUrl
     */
    protected $urlService;
    public function indexAction() {
        $queryId = $this->params()->fromRoute('queryId');
        $contents = $this->getContents($queryId);
        $query = $this->getQueriesService()->getQueryById($queryId);

        $feed = new Feed;
        $feed->setLink($this->getBaseUrl());
//        var_dump($queryId);
        $feed->setFeedLink($this->getBaseUrl() . $this->url()->fromRoute('rss', array('queryId' => $queryId)), 'rss');
        $feed->setDescription($query['name']);
        $feed->setTitle($query['name']);
        $feed->setDateModified(time());
//        $this->_site = Manager::getService('Sites')->findById($this->_pageInfo['site']);
//        var_dump($query, $contents);
        foreach ($contents as $content) {
            $entry = $feed->createEntry();
            $entry->setTitle($content['text']);
            //->url(array('pageId'=>$output['currentPage'],'locale'=>$pageLocale,'content-id'=>$contentId));
//            $pageUrl = $this->getUrlService()->getContentUrl(
//                $content['id'] , 'en'
//            );
//            var_dump($pageUrl);
//            $entry->setLink();
            $entry->addAuthor(array(
                'name'  => $content['createUser']['fullName'],
            ));
            $entry->setDateModified($content['lastUpdateTime']);
            $entry->setDateCreated($content['createTime']);
            $entry->setDescription($content['fields']['summary']);
            $feed->addEntry($entry);
        }
//        var_dump($query, $contents);
        /**
         * @var $response \Zend\Http\PhpEnvironment\Response
         */
        $response = $this->getResponse();
        $headers = $response->getHeaders();
        //$headers->addHeaderLine('Content-Type', 'application/rss+xml');
        $headers->addHeaderLine('Content-Type', 'text/html');


        $response->setContent($feed->export('rss'));
        return $response;
    }

    protected function getContents($queryId) {
        $filters = $this->getQueriesService()->getFilterArrayById($queryId);
        $contentArray = array(
            'count' => 0,
            'data' => array(),
        );
        if ($filters !== false) {
            $filters["sort"] = isset($filters["sort"]) ? $filters["sort"] : array();
            $contentArray = $this->getContentsService()->getOnlineList($filters["filter"], $filters["sort"]);
            $contentArray['count'] = max(0, $contentArray['count']);
        }
        return $contentArray['data'];
    }

    /**
     * @return \Rubedo\Interfaces\Collection\IQueries
     */
    protected function getQueriesService() {
        if (empty($this->queriesService)) {
            $this->queriesService = Manager::getService('Queries');
        }
        return $this->queriesService;
    }

    /**
     * @return \Rubedo\Interfaces\Collection\IContents
     */
    protected function getContentsService() {
        if (empty($this->contentsService)) {
            $this->contentsService = Manager::getService('Contents');
        }
        return $this->contentsService;
    }

    /**
     * @return \Rubedo\Interfaces\Collection\IContentTypes
     */
    protected function getContentTypesService() {
        if (empty($this->contentTypeService)) {
            $this->contentTypeService = Manager::getService('ContentTypes');
        }
        return $this->contentTypeService;
    }

    /**
     * @return \Rubedo\Interfaces\Router\IUrl
     */
    protected function getUrlService() {
        if (empty($this->urlService)) {
            $this->urlService = Manager::getService('Url');
        }
        return $this->urlService;
    }

    protected function getBaseUrl() {
        /**
         * @var $request \Zend\Http\Request
         */
        $request = $this->getRequest();
        $uri = $request->getUri();
        $scheme = $uri->getScheme();
        $host = $uri->getHost();
        return sprintf('%s://%s', $scheme, $host);
    }
}
