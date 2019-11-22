<?php
namespace devskyfly\php56\libs\arr;

use devskyfly\php56\types\Arr;
use devskyfly\php56\types\Nmbr;
use devskyfly\php56\types\Str;

class Keys
{
    const CASE_LOWER=CASE_LOWER;
    const CASE_UPPER=CASE_UPPER;
    
    /**
     * Return array keys
     *
     * @param array $array
     * @throws \InvalidArgumentException
     * @return array
     */
    public static function getKeys($array)
    {
        if(!Arr::isArray($array)){
            throw new \InvalidArgumentException('Param $array is not array type.');
        }
        return array_keys();
    }
    
    /**
     *
     * @param array $array
     * @param string|integer $key
     * @throws \Exception
     * @return boolean
     */
    public static function keyExists($array,$key)
    {
        if(!Arr::isArray($array)){
            throw new \InvalidArgumentException('Param $array is not array type.');
        }
        
        if((!Nmbr::isInteger($key))
            ||(!Str::isString($key))){
                throw new \InvalidArgumentException('Param $key is not string or integer type.');
        }
        
        return array_key_exists($key, $array);
    }
    
    /**
     * Return array with keys in lower case
     *
     * @param array $array
     * @return array
     */
    public static function keysToLowerCase($array)
    {
        return array_change_key_case($array,self::CASE_LOWER);
    }
    
    /**
     * Return array with keys in upper case
     *
     * @return array
     */
    public static function keysToUpperCase($array)
    {
        return array_change_key_case($array,self::CASE_UPPER);
    }
    
}