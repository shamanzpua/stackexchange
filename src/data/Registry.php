<?php
namespace shamanzpua\stackexchange\data;

class Registry
{
    const KEY_PAGE = 'page';
    const KEY_QUESTIONS = 'questions';
    const KEY_QUESTIONS_WITH_ANSWERS = 'questions-with-answers';
    const DEFAULT_PAGE = 1;
    
    private static $container = [
        self::KEY_PAGE => self::DEFAULT_PAGE,
        self::KEY_QUESTIONS_WITH_ANSWERS => [],
        self::KEY_QUESTIONS => [],
    ];
    
    public static function set($key, $value)
    {
        
        self::$container[$key] = (is_array($value)) 
            ? array_merge(self::$container[$key], $value)
            : $value;
    }

    public static function get($key)
    {
        return self::$container[$key];
    }   
}
