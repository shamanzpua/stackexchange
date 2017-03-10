<?php
namespace shamanzpua\stackexchange\request\builders;

use shamanzpua\apirequest\builders\BuilderStrategyInterface;

/**
 * Class for building request for questions/{question_id}/answers api
 */
class AnswersRequestBuilder extends StackexchangeRequestBuilder implements BuilderStrategyInterface
{

    const ALLOWED_METHODS = ['GET'];

    protected $api = "/questions/{question_id}/answers";

    /**
     * @inheritdoc
     */
    public function getRequiredParams()
    {
        $requiredParams = parent::getRequiredParams();
        $requiredParams['path'] = ['question_id'];
        return $requiredParams;
    }

    /**
     * @inheritdoc
     */
    public function getAllowedPathParams()
    {
        return array_merge(
            parent::getAllowedPathParams(),
            [
                'question_id' => []
            ]
        );
    }

    /**
     * @inheritdoc
     */
    public function getAllowedQueryParams()
    {
        return array_merge(
            parent::getAllowedQueryParams(),
            [
                'filter' => ['withBody'],
                'sort' => ['activity', 'creation', 'votes'],
                'order' => ['asc', 'desc'],
                'pagesize' => [],
                'page' => [],
                'notice' => ['true', 'false'],
                'wiki' => ['true', 'false'],
                'body' => [],
                'nottagged' => [],
                'tagged' => [],
                'title' => [],
                'user' => [],
                'url' => [],
                'views' => [],
            ]
        );
    }

    /**
     * Build request
     */
    public function build()
    {
        $this->buildPath()->buildQuery()->create();
    }
}
