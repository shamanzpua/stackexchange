<?php
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
namespace shamanzpua\stackexchange\data\process\stackoverflow;

use shamanzpua\stackexchange\data\process\Sortable;

/**
 * Description of Sort
 *
 * @author shaman
 */
class Sort implements Sortable
{
    public function sortArrayInArray($data, $field, $sort)
    {
        $array = [];
        foreach ($data as $key => $row) {
            $array[$key] = $row[$field];
        }
        array_multisort($array, $sort, $data);
        return $data;
    }
}
