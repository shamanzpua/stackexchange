<?php
namespace shamanzpua\stackexchange\request;

use shamanzpua\apirequest\RequestConfig;
use shamanzpua\apirequest\Request;
use shamanzpua\stackexchange\request\builders\SearchExcerptsRequestBuilder;
use shamanzpua\stackexchange\request\builders\AnswersRequestBuilder;
use shamanzpua\apirequest\Api;

/**
 * Stackechchange api class
 */
class StackexchangeApi extends Api
{

    /**
     * Api baseurl
     */
    protected $apiBaseUrl = 'https://api.stackexchange.com/2.2';

    /**
     * Api key
     */
    protected $apiKey;
    
    /**
     * Site for parsing
     */
    protected $site;
    
    /**
     * costructor api key setting
     */
    public function __construct($apiKey, $site)
    {
        $this->setApiKey($apiKey);
        $this->setSite($site);
    }

    /**
     * Get api key
     *
     * @return string
     * @throws Exception
     */
    public function getApiKey()
    {
        if (!$this->apiKey) {
            throw new Exception("'apiKey' property is not configured...");
        }
        return $this->apiKey;
    }
    
    /**
     * Get parse site
     *
     * @return string
     * @throws Exception
     */
    public function getSite()
    {
        if (!$this->site) {
            throw new Exception("'site' property is not configured...");
        }
        return $this->site;
    }
    
    /**
     * Set api key
     *
     * @param string $key
     */
    public function setApiKey($key)
    {
        $this->apiKey = $key;
    }
    /**
     * Set site
     *
     * @param string $site
     */
    public function setSite($site)
    {
        $this->site = $site;
    }
    
    /**
     * @param string $className
     * @return RequestConfigInterface
     */
    public function createConfigurator($className)
    {
        $configurator = parent::createConfigurator($className);
        return $configurator
                ->setQueryParam('key', $this->getApiKey())
                ->setQueryParam('site', $this->getSite());
    }

    /**
     * api questions/{question_id}/answers
     */
    public function apiQuestionAnswers($ids, $params)
    {
        $queryParams = [
            'filter' => 'withBody',
        ];
        
        if (is_array($ids)) {
            $ids = implode(';', $ids);
        }
        
        $queryParams = array_merge($queryParams, $params);

        $requestConfig = $this->createConfigurator(RequestConfig::class);

        $requestConfig->setHttpMethod(RequestConfig::HTTP_METHOD_GET)
            ->setQueryParams($queryParams)
            ->setPathParam('question_id', $ids);

        return $this->sendRequest(
            new Request($this->createBuilder(new AnswersRequestBuilder($requestConfig)))
        );
    }

    /**
     * api /search/excerpts
     */
    public function apiSearchExcerpts($queryParams)
    {
        $requestConfig = $this->createConfigurator(RequestConfig::class);

        $requestConfig->setHttpMethod(RequestConfig::HTTP_METHOD_GET)
            ->setQueryParams($queryParams);

        return $this->sendRequest(
            new Request($this->createBuilder(new SearchExcerptsRequestBuilder($requestConfig)))
        );
    }
}
