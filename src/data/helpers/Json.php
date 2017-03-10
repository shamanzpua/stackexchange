<?php
namespace shamanzpua\stackexchange\data\helpers;

class Json
{
    /**
     * @param string $json
     * @param boolean $assoc
     * @return type
     */
    public static function decode($json, $assoc = false)
    {
        return json_decode($json, $assoc);
    }
    
    /**
     * @param $mixed
     * @return string
     */
    public static function encode($mixed)
    {
        return json_encode($mixed);
    }
}
