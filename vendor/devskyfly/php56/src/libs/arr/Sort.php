<?php
namespace devskyfly\php56\libs\arr;

use devskyfly\php56\types\Arr;
use devskyfly\php56\types\Vrbl;
use devskyfly\php56\types\Nmbr;

class Sort
{
    const SORT_ASC=SORT_ASC;
    const SORT_DESC=SORT_DESC;
    const SORT_REGULAR=SORT_REGULAR;
    const SORT_NUMERIC=SORT_NUMERIC;
    const SORT_STRING=SORT_STRING;
    const SORT_LOCALE_STRING=SORT_LOCALE_STRING;
    const SORT_NATURAL=SORT_NATURAL;
    const SORT_FLAG_CASE=SORT_FLAG_CASE;
    
    /**
     * Sort array by values using flag to define sort algorithm
     * 
     * @param array $array
     * @param integer $flag
     * @throws \InvalidArgumentException
     * @return boolean
     */
    public static function sort(&$array,$flag=self::SORT_REGULAR)
    {
        if(!Arr::isArray($array)){
            throw new \InvalidArgumentException('Param $array is not array type.');
        }
        if(!Nmbr::isInteger($flag)){
            throw new \InvalidArgumentException('Param $flag is not integer type.');
        }
        return sort($array,$flag);
    }
    
    /**
     * Sort array by handler function with saving keys
     * 
     * @param array $array
     * @param callable $handler
     * @throws \InvalidArgumentException
     * @return boolean
     */
    public static function sortByHandlerWithKeysSave(&$array,$handler)
    {
        if(!Arr::isArray($array)){
            throw new \InvalidArgumentException('Param $array is not array type.');
        }
        if(!Vrbl::isCallable($handler)){
            throw new \InvalidArgumentException('Param $handler is not callable type.');
        }
        return uasort($array,$handler);
    }
    
    /**
     * Sort array by keys and handler function
     *
     * @param array $array
     * @param callable $handler
     * @throws \InvalidArgumentException
     * @return boolean
     */
    public static function sortByKeysAndHandler(&$array,$handler)
    {
        if(!Arr::isArray($array)){
            throw new \InvalidArgumentException('Param $array is not array type.');
        }
        if(!Vrbl::isCallable($handler)){
            throw new \InvalidArgumentException('Param $handler is not callable type.');
        }
        return uksort($array,$handler);
    }
    
    /**
     * Sort array by handler function with saving keys
     *
     * @param array $array
     * @param callable $handler
     * @throws \InvalidArgumentException
     * @return boolean
     */
    public static function sortByHandler(&$array,$handler)
    {
        if(!Arr::isArray($array)){
            throw new \InvalidArgumentException('Param $array is not array type.');
        }
        if(!Vrbl::isCallable($handler)){
            throw new \InvalidArgumentException('Param $handler is not callable type.');
        }
        return usort($array,$handler);
    }
}