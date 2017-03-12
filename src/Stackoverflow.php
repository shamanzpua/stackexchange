<?php
namespace shamanzpua\stackexchange;

use shamanzpua\stackexchange\request\StackexchangeApi;
use shamanzpua\stackexchange\data\process\stackoverflow\Process;
use shamanzpua\stackexchange\data\helpers\Json;
use shamanzpua\stackexchange\data\Registry;

/**
 * Stackechchange api class
 */
class Stackoverflow implements StackexchangeInterface
{

    const SITE_STACKOVERFLOW = 'stackoverflow';
    const PAGESIZE = 30;
    const MIN_ANSWERS = 1;
    const FIELD_ANSWERS = 'answers';

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

    public function grab($search, $limit = Registry::DEFAULT_PAGE)
    {
        $ordering = [
            'sort' => 'votes',
            'order' => 'desc',
            'pagesize' => self::PAGESIZE,
        ];


        $response = $this
            ->api
            ->apiSearchExcerpts(array_merge($ordering, [
            'q' => $search,
            'answers' => self::MIN_ANSWERS,
            'page' => Registry::get(Registry::KEY_PAGE),
        ]));
        $questions = $this
            ->processor
            ->getSearchExcerptsIds(Json::decode($response, true));
        Registry::set(Registry::KEY_QUESTIONS, $questions);
        
        if (!empty($questions) && (Registry::get(Registry::KEY_PAGE) < $limit)) {
            $nextPage = Registry::get(Registry::KEY_PAGE) + 1;
            Registry::set(Registry::KEY_PAGE, $nextPage);        
            return $this->grab($search);
        }
        
        $this->parseAnswers($ordering);

        return Registry::get(Registry::KEY_QUESTIONS_WITH_ANSWERS);
    }

    public function parseAnswers($ordering)
    {
        $questions = Registry::get(Registry::KEY_QUESTIONS);
        if (!$questions) {
            return;
        }
        foreach ($questions as $key => $item) {
            $responseAnswers = $this->api->apiQuestionAnswers(
                $item[Process::TARGET_QUESTION_ID], $ordering
            );

            $questions[$key][self::FIELD_ANSWERS] = $this
                ->processor
                ->getAnswersBody(Json::decode($responseAnswers, true));
        } 
        Registry::set(Registry::KEY_QUESTIONS_WITH_ANSWERS, $questions);
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
