<?php
namespace devskyfly\php56\libs\arr;

use devskyfly\php56\types\Arr;
use devskyfly\php56\types\Vrbl;

class Diff
{
    /**
     * Return array with elements from array_1 that do not exist in array_2 with additional index check
     *
     * @param array $array_1
     * @param array $array_2
     * @throws \InvalidArgumentException
     */
    public static function getDifferenceAssoscByValue($array_1,$array_2)
    {
        if(!Arr::isArray($array_1)){
            throw new \InvalidArgumentException('Param $array_1 is not array type.');
        }
        if(!Arr::isArray($array_2)){
            throw new \InvalidArgumentException('Param $array_2 is not array type.');
        }
        return array_diff_assoc($array1, $array2);
    }
    
    /**
     * Return array with elements from array_1 that do not exist in array_2 using user defined function with additional index check
     *
     * @param array $array_1
     * @param array $array_2
     * @param string|callable $handler
     * @throws \InvalidArgumentException
     * @return array
     */
    public static function getUserDifferenceAssoscByValue($array_1,$array_2,$handler)
    {
        if(!Arr::isArray($array_1)){
            throw new \InvalidArgumentException('Param $array_1 is not array type.');
        }
        if(!Arr::isArray($array_2)){
            throw new \InvalidArgumentException('Param $array_2 is not array type.');
        }
        if(!Vrbl::isCallable($handler)){
            throw new \InvalidArgumentException('Param $handler is not callable type.');
        }
        return array_diff_uassoc($array1, $array2, $handler);
    }
    
    /**
     * Return array with elements from array_1 that do not exist in array_2 by key value
     *
     * @param array $array1
     * @param array $array2
     * @throws \InvalidArgumentException
     * @return array
     */
    public static function getDifferenceByKeys($array1, $array2)
    {
        if(!Arr::isArray($array_1)){
            throw new \InvalidArgumentException('Param $array_1 is not array type.');
        }
        if(!Arr::isArray($array_2)){
            throw new \InvalidArgumentException('Param $array_2 is not array type.');
        }
        return array_diff_key($array1, $array2);
    }
    
    /**
     * Return array with elements from array_1 that do not exist in array_2 by key value using user defined function
     *
     * @param array $array_1
     * @param array $array_2
     * @param string|callable $handler
     * @throws \InvalidArgumentException
     * @return array
     */
    public static function getUserDifferenceByKeys($array_1,$array_2,$handler)
    {
        if(!Arr::isArray($array_1)){
            throw new \InvalidArgumentException('Param $array_1 is not array type.');
        }
        if(!Arr::isArray($array_2)){
            throw new \InvalidArgumentException('Param $array_2 is not array type.');
        }
        if(!Vrbl::isCallable($handler)){
            throw new \InvalidArgumentException('Param $handler is not callable type.');
        }
        return array_diff_ukey($array1, $array2,$handler);
    }
    
    
    /**
     * Return array with elements from array_1 that do not exist in array_2
     *
     * @param array $array_1
     * @param array $array_2
     * @throws \InvalidArgumentException
     */
    public static function getDifference($array_1,$array_2)
    {
        if(!Arr::isArray($array_1)){
            throw new \InvalidArgumentException('Param $array_1 is not array type.');
        }
        if(!Arr::isArray($array_2)){
            throw new \InvalidArgumentException('Param $array_2 is not array type.');
        }
        return array_diff_assoc($array1, $array2);
    }
}