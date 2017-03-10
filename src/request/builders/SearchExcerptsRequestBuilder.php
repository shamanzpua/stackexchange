<?php
namespace shamanzpua\stackexchange\request\builders;

use shamanzpua\apirequest\builders\BuilderStrategyInterface;

/**
 * Class for building request for /search/excerpts api
 */
class SearchExcerptsRequestBuilder extends StackexchangeRequestBuilder implements BuilderStrategyInterface
{
    const ALLOWED_METHODS = ['GET'];

    protected $api = "/search/excerpts";

    /**
     * @inheritdoc
     */
    public function getAllowedQueryParams()
    {
        return array_merge(
            parent::getAllowedQueryParams(),
            [
                'q' => [],
                'sort' => ['activity', 'creation', 'votes', 'relevance'],
                'order' => ['asc', 'desc'],
                'accepted' => ['true', 'false'],
                'closed' => ['true', 'false'],
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
        $this->buildQuery()->create();
    }
}
