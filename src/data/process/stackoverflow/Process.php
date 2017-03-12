<?php
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
namespace shamanzpua\stackexchange\data\process\stackoverflow;

use shamanzpua\stackexchange\data\process\Processable;
use shamanzpua\stackexchange\data\process\Sortable;

/**
 * Description of Process
 *
 * @author shaman
 */
class Process implements Processable
{
    
    public function __construct()
    {
        $this->sort = new Sort();
    }
    
    const TARGET_BODY = 'body';
    const TARGET_QUESTION_ID = 'question_id';
    const TARGET_SCORE = 'score';
    
    /** @var Sortable */
    private $sort;
    
    /**
     * @param \common\components\stackoverflow\stackexchange\data\process\Sortable $sort
     */
    public function setSort(Sortable $sort)
    {
        $this->sort = $sort;
        return $this;
    }
    
    /**
     * @return Sortable
     */
    public function getSort()
    {
        return $this->sort;
    }
    
    /**
     * get question ids
     *
     * @param array $data
     * @return array
     */
    public function getSearchExcerptsIds($data)
    {
        return $this->getTargetData($data, [self::TARGET_QUESTION_ID, self::TARGET_BODY]);
    }
    
    /**
     * get answers body
     *
     * @param array $data
     * @return array
     */
    public function getAnswersBody($data)
    {
        return $this->getSort()->sortArrayInArray(
            $this->getTargetData($data, [self::TARGET_BODY, self::TARGET_SCORE]),
            self::TARGET_SCORE,
            SORT_DESC
        );
    }
    
    /**
     * Get target data from parse results
     *
     * @param array $data
     * @param string|array $target
     * @return array
     */
    public function getTargetData($data, $target)
    {
        try {
            $targets = [];
            foreach ($data['items'] as $key => $value) {
                $targets[] = (is_array($target)) ?
                    $this->getManyTarget($value, $target) :
                    $this->getOneTarget($value, $target);
            }
            return $targets;
        } catch (\Exception $ex) {
            throw new \Exception($ex->getMessage());
        }
    }
    
    /**
     * Get many targets
     *
     * @param array $item
     * @param array $targets
     * @return array
     */
    public function getManyTarget($item, $targets)
    {
        $data = [];
        foreach ($targets as $target) {
            $data[$target] = $item[$target];
        }
        return $data;
    }
    
    /**
     * Get one target
     *
     * @param array $item
     * @param string $target
     * @return array
     */
    public function getOneTarget($item, $target)
    {
        return $item[$target];
    }
}
