<?php
namespace shamanzpua\stackexchange;

/**
 * @author shaman
 */
interface StackexchangeInterface
{
    /**
     * @return shamanzpua\apirequest\ApiInterface
     */
    public function getApi();
    
    /**
     * @return shamanzpua\stackexchange\data\process\ProcessInterface
     */
    public function getProcessor();
}
