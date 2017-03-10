<?php
namespace shamanzpua\stackexchange;

use shamanzpua\stackexchange\request\StackexchangeApi;
use shamanzpua\stackexchange\data\process\stackoverflow\Process;
use shamanzpua\stackexchange\data\helpers\Json;

/**
 * Stackechchange api class
 */
class Stackoverflow implements StackexchangeInterface
{
    const SITE_STACKOVERFLOW = 'stackoverflow';
    /**
     * @var StackexchangeApi
     */
    private $api;
    
    /**
     * @var Process
     */
    private $processor;
    
        
    public function __construct($apiKey)
    {
        if (!$apiKey) {
            throw new \Exception("Error: api key is not set");
        }
        $this->api = new StackexchangeApi($apiKey, self::SITE_STACKOVERFLOW);
        $this->processor = new Process();
    }
    
    public function grab($search)
    {
        $ordering = [
            'sort' => 'votes',
            'order' => 'desc',
        ];
        
        $response = $this
            ->api
            ->apiSearchExcerpts(array_merge($ordering, ['q' => $search]));
        $ids=$this
            ->processor
            ->getSearchExcerptsIds(Json::decode($response, true));
        if (!$ids) {
            return false;
        }
        $response = $this->api->apiQuestionAnswers(
            implode(";", $ids),
            $ordering
        );
        
        $answers = $this
            ->processor
            ->getAnswersBody(Json::decode($response, true));
        return $answers;
    }


    /**
     * @return type
     */
    public function getApi()
    {
        return $this->api;
    }

    /**
     * @return type
     */
    public function getProcessor()
    {
        return $this->processer;
    }
}
