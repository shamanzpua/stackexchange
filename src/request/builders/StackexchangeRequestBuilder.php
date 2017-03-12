<?php
namespace shamanzpua\stackexchange\request\builders;

use shamanzpua\apirequest\builders\AbstractRequestBuilder;

/**
 * Abstract request class
 */
abstract class StackexchangeRequestBuilder extends AbstractRequestBuilder
{

    /**
     * Get array of allowed query params
     */
    public function getAllowedQueryParams()
    {
        return [
            'key' => [],
            'site' => [],
            'page' => [],
            'pagesize' => [],
        ];
    }

    /**
     * Get array of path params
     */
    public function getRequiredParams()
    {
        return [
            'body' => [],
            'path' => [],
            'query' => ['site'],
        ];
    }
}
