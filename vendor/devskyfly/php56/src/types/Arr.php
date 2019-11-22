<?php
namespace devskyfly\php56\types;

class Arr
{
    const ARRAY_FILTER_USE_KEY=ARRAY_FILTER_USE_KEY;
    const ARRAY_FILTER_USE_BOTH=ARRAY_FILTER_USE_BOTH;
    
    /**
     * Define whether the variable is array 
     * 
     * @param mixed $val
     * @return boolean
     */
    public static function isArray($val)
    {
        return is_array($val);
    }
    
    /**
     * Define whether item is exists in array
     *
     * If strict is true, then compare mode will be strict
     * @param mixed $needle
     * @param array $haystack
     * @return boolean
     */
    public static function inArray($needle,$haystack,$strict=false)
    {
        return in_array($needle,$haystack,$strict=false);
    }
    
    /**
     * Return an array of strings, each of which is a substring of string
     * formed by splitting it on boundaries formed by the string delimiter.
     * 
     * @param string $delimeter
     * @param string $str
     * @throws \InvalidArgumentException
     */
    public static function explode($delimeter,$str)
    {
        if(!Str::isString($delimeter)){
            throw new \InvalidArgumentException('Parameter $delimiter is not string type.');
        }
        if(!Str::isString($str)){
            throw new \InvalidArgumentException('Parameter $str is not string type.');
        }
        if(!Vrbl::isEmpty($str)){
            throw new \InvalidArgumentException('Parameter $str is empty.');
        }
            
        return explode($delimeter,$str);
    }
    
    /**
     * Return array size
     *
     * @param array $array
     * @throws \InvalidArgumentException
     * @return integer
     */
    public static function getSize($array)
    {
        if(!self::isArray($array)){
            throw new \InvalidArgumentException('Param $array is not array type.');
        }
        return count($array);
    }
    
    /**
     * Return array with keys that were values and values that equal to value freqvecy
     * 
     * @param array $array
     * @throws \InvalidArgumentException
     */
    public static function countValues($array)
    {
        if(!self::isArray($array)){
            throw new \InvalidArgumentException('Param $array is not array type.');
        }
        return array_count_values($array);
    }
    
    /**
     * Return chuncked array
     * 
     * Return array with elements separeted by size.
     * If save_keys param is true - keys values are saved.
     * @param array $array
     * @param int $size
     * @param boolean $save_keys
     * @return array
     */
    public static function getChunked($array,$size,$save_keys=false)
    {
        if(!self::isArray($array)){
            throw new \InvalidArgumentException('Param $array is not array type.');
        }
        
        if(!Nmbr::isInteger($size)){
            throw new \InvalidArgumentException('Param $size is not integer type.');
        }
        
        if(!Lgc::isBoolean($save_keys)){
            throw new \InvalidArgumentException('Param $save_keys is not bool type.');
        }
        return array_chunk($array, $size,$save_keys);
    }
    
    /**
     * Return column of passed array 
     * 
     * If index_key param is set, return value items would have index keys from this index key
     * @param array $array
     * @param integer|string|null $column
     * @param integer|string|null $index_column
     * @return array
     */
    public static function getColumn($array,$column,$index_column=null)
    {
        return array_column($array,$column,$index_column);
    }
    
    /**
     * Return array indexed by column value, but not no ordered
     *
     * Notice that returned array has index values related to column value in order.
     * But items in result arraay is not sorted by index.
     *  
     * @throws \InvalidArgumentException::
     * @param array $array
     * @param integer|string $index_column
     * @return array
     */
    public static function indexByColumn($array,$index_column)
    {
        if(!self::isArray($array)){
            throw new \InvalidArgumentException('Param $array is not array type.');
        }
              
        if(!self::columnExists($array, $index_column)){
            throw new \InvalidArgumentException('Key '.$index_column.' does not exist');
        }
        
        return array_column($array,null,$index_column);
    }
    
    /**
     * Define whether array have key
     * 
     * @param array $array
     * @param string|integer $key
     * @throws \InvalidArgumentException
     * @return boolean
     */
    public static function keyExists($array,$key)
    {
        if(!self::isArray($array)){
            throw new \InvalidArgumentException('Param $array is not array type.');
        }
        
        if((!Str::isString($key))&&(!Nmbr::isInteger($key))){
            throw new \InvalidArgumentException('Param $key is not string or integer type.');
        }
            
        return array_key_exists($key,$array);
    }
    
    /**
     * Define whether array have column
     * 
     * In other words, if every row have neaded key function return true 
     * @param array $array
     * @param string|integer $key
     * @throws \InvalidArgumentException
     * @return boolean
     */
    public static function columnExists($array,$key)
    {
        if(!self::isArray($array)){
            throw new \InvalidArgumentException('Param $array is not array type.');
        }
        
        if((!Str::isString($key))&&(!Nmbr::isInteger($key))){
            throw new \InvalidArgumentException('Param $key is not string or integer type.');
        }
        
        foreach ($array as $item){
            if(!self::keyExists($item, $key)){
                return false;
            }
        }
        return true;
    }
    
    /**
     * Return array with keys and values consistes from passed params
     * 
     * @param array $keys
     * @param array $values
     * @throws \InvalidArgumentException
     * @throws \Exception
     * @return array
     */
    public static function getCombined($keys,$values)
    {
        if(!self::isArray($keys)){
            throw new \InvalidArgumentException('Param $keys is not array type.');
        }
        if(!self::isArray($values)){
            throw new \InvalidArgumentException('Param $values is not array type.');
        }
        if(self::getSize($keys)==self::getSize($values)){
            throw new \Exception('Arrays size is not equal.');
        }
        
        return array_combine($keys, $values);
    }
    
    /**
     * Create array with passed keys and fill it by values
     *
     * @param array $keys
     * @param mixed $values
     * @throws \InvalidArgumentException
     * @return array
     */
    public static function createArrayUsingKeysAndValues($keys,$values)
    {
        if(!self::isArray($keys)){
            throw new \InvalidArgumentException('Param $keys is not array type.');
        }
        return array_fill_keys($keys, $value);
    }
    
    /**
     * Create array using range
     * 
     * @param integer $start
     * @param integer $end
     * @param number $step
     * @throws \InvalidArgumentException
     * @return array
     */
    public static function createArrayByRange($start,$end,$step=1)
    {
        if(!Nmbr::isInteger($start)){
            throw new \InvalidArgumentException('Param $start is not array type.');
        }
        if(!Nmbr::isInteger($end)){
            throw new \InvalidArgumentException('Param $end is not array type.');
        }
        if(!Nmbr::isInteger($step)){
            throw new \InvalidArgumentException('Param $step is not array type.');
        }
        
        return range($start,$end,$step);
    }
    
    /**
     * Create array by filling it's items
     * 
     * @param integer $start
     * @param integer $end
     * @param mixed $value
     * @throws \InvalidArgumentException
     * @return array
     */
    public static function createFilledByValues($start,$end,$value)
    {
        if(!Nmbr::isInteger($start)){
            throw new \InvalidArgumentException('Param $start is not array type.');
        }
        if(!Nmbr::isInteger($end)){
            throw new \InvalidArgumentException('Param $end is not array type.');
        }
        return array_fill($start,$end,$value);
    }
    
    /**
     * Return filtered array.
     * 
     * @param array $array
     * @param callable $handler
     * @throws \InvalidArgumentException
     * @return array
     */
    public static function getFiltered($array,$handler)
    {
        if(!self::isArray($array)){
            throw new \InvalidArgumentException('Param $array is not array type.');
        }
        if(!Vrbl::isCallable($handler)){
            throw new \InvalidArgumentException('Param $handler is not array type.');
        }
        return array_filter($array,$handler,self::ARRAY_FILTER_USE_BOTH);
    }
    
    /**
     * Change keys and values between each other
     * 
     * @param array $array
     * @throws \InvalidArgumentException
     * @throws \RuntimeException
     * @return array
     */
    public static function getFliped($array)
    {
        if(!self::isArray($array)){
            throw new \InvalidArgumentException('Param $array is not array type.');
        }
        $result=flip($array);
        if(Vrbl::isNull($result)){
            throw new \RuntimeException("Array flip exception.");
        }
        return $result;
    }
    
    /**
     * Aplly handler function to each array element
     * @param callable $handler
     * @param array $array
     * @throws \InvalidArgumentException
     * @return array
     */
    public static function map($handler,$array)
    {
        if(!Vrbl::isCallable($handler)){
            throw new \InvalidArgumentException('Param $handler is not callable type.');
        }
        if(!self::isArray($array)){
            throw new \InvalidArgumentException('Param $array is not array type.');
        }
        return array_map($handler,$array);
    }
    
    /**
     * Merge arrays
     * @param array $array_1
     * @param array $array_2
     * @throws \InvalidArgumentException
     * @return array
     */
    public static function merge($array_1,$array_2)
    {
        if(!self::isArray($array_1)){
            throw new \InvalidArgumentException('Param $array_1 is not array type.');
        }
        if(!self::isArray($array_2)){
            throw new \InvalidArgumentException('Param $array_2 is not array type.');
        }
        return array_merge($array_1,$array_2);
    }
    
    /**
     * Create array from another by filling it by value to definde size 
     * 
     * If $size <= size of $array only copy would return
     * @param array $array
     * @param integer $size
     * @param mixed $value
     * @return array
     */
    public static function getFilledToSizeByValue($array,$size,$value)
    {
        if(!self::isArray($array)){
            throw new \InvalidArgumentException('Param $array is not array type.');
        }
        if(!Nmbr::isInteger($size)){
            throw new \InvalidArgumentException('Param $size is not integer type.');
        }
        
        return array_pad($array,$size,$value);
    }
    
    /**
     * Add item to array
     * 
     * @param array $array
     * @param mixed $value
     * @throws \InvalidArgumentException
     * @return integer
     */
    public static function pushItem(&$array,$value)
    {
        if(!self::isArray($array)){
            throw new \InvalidArgumentException('Param $array is not array type.');
        }
        return array_push($array,$value);
    }
    
    /**
     * Remove last item from array and return it
     *
     * @param array $array
     * @throws \InvalidArgumentException
     * @return integer
     */
    public static function popItem(&$array)
    {
        if(!self::isArray($array)){
            throw new \InvalidArgumentException('Param $array is not array type.');
        }
        return array_pop($array);
    }
    
    /**
     * Return first item of array, decrease array length.
     * 
     * All digit keys would be edited by order from 0, all string keys save old values
     * @param array $array
     * @throws \InvalidArgumentException
     * @return mixed
     */
    public static function shiftItem(&$array)
    {
        if(!self::isArray($array)){
            throw new \InvalidArgumentException('Param $array is not array type.');
        }
        return array_shift($array);
    }
    
    /**
     * Product array element and return it
     * @param array $array
     * @throws \InvalidArgumentException
     * @return number
     */
    public static function getProduct($array)
    {
        if(!self::isArray($array)){
            throw new \InvalidArgumentException('Param $array is not array type.');
        }
        return product($array);
    }
    
    /**
     * Sum array element and return it
     * 
     * @param array $array
     * @throws \InvalidArgumentException
     * @return number
     */
    public static function getSumm($array)
    {
        if(!self::isArray($array)){
            throw new \InvalidArgumentException('Param $array is not array type.');
        }
        return array_sum($array);
    }
    
    /**
     * Return serveral random array elements
     * 
     * @param array $array
     * @param number $num
     * @throws \InvalidArgumentException
     * @return mixed
     */
    public static function getRand($array,$num=1)
    {
        if(!self::isArray($array)){
            throw new \InvalidArgumentException('Param $array is not array type.');
        }
        if(!Nmbr::isInteger($num)){
            throw new \InvalidArgumentException('Param $num is not integer type.');
        }
        return array_rand($array,$num);
    }
    
    /**
     * Return 
     * @param array $array
     * @param integer $offset
     * @param integer|null $length
     * @throws \InvalidArgumentException
     * @return array
     */
    public static function getSlice($array,$offset,$length=null)
    {
        if(!self::isArray($array)){
            throw new \InvalidArgumentException('Param $array is not array type.');
        }
        if(!Nmbr::isInteger($offset)){
            throw new \InvalidArgumentException('Param $offset is not integer type.');
        }
        if(!Vrbl::isNull($length))
        {
            if(!Vrbl::isNumber($length)){
                throw new \InvalidArgumentException('Param $length is not integer type.');
            }
            $cnt=self::getSize($array);
            if($cnt<($offset+$length))
            {
                throw new \LengthException('Array slice is bigger then target array.');
            }
        }
        return array_slice($array,$num,$length);
    }
    
    
    
    /**
     * Replace array items, if replacement is not empty array, use it for replacement
     * @param array $array
     * @param integer $offset
     * @param integer $length
     * @param array $replacement
     * @throws \InvalidArgumentException
     * @throws \LengthException
     * @return array
     */
    public static function splice(&$array,$offset,$length=null,$replacement=[])
    {
        if(!self::isArray($array)){
            throw new \InvalidArgumentException('Param $array is not array type.');
        }
        if(!Nmbr::isInteger($offset)){
            throw new \InvalidArgumentException('Param $offset is not integer type.');
        }
        if(!Vrbl::isNull($length))
        {
            if(!Vrbl::isNumber($length)){
                throw new \InvalidArgumentException('Param $length is not integer type.');
            }
            $cnt=self::getSize($array);
            if($cnt<($offset+$length))
            {
                throw new \LengthException('Array slice is bigger then target array.');
            }
        }
        if(!self::isArray($replacement)){
            throw new \InvalidArgumentException('Param $replacement is not array type.');
        }
        return array_splice($array,$num,$length,$replacement);
    }
    
    /**
     * Replace elements in master array from slave array if keys do not exist, and replace elements if keys are equal
     * 
     * @param array $master
     * @param array $slave
     * @throws \InvalidArgumentException
     * @return array
     */
    public static function replace($master,$slave)
    {
        if(!self::isArray($master)){
            throw new \InvalidArgumentException('Param $master is not array type.');
        }
        if(!self::isArray($slave)){
            throw new \InvalidArgumentException('Param $slave is not array type.');
        }
        return array_replace($master, $slave);
        
    }
    
    /**
     * Return array with element binded with keys in reverse order
     * 
     * @param array $array
     * @throws \InvalidArgumentException
     * @return array
     */
    public static function reverse($array)
    {
        if(!self::isArray($array)){
            throw new \InvalidArgumentException('Param $array is not array type.');
        }
        return array_reverse($array);
    }
    
    /**
     * Search first match and return its index
     * 
     * @param array $array
     * @param mixed $target
     * @throws \InvalidArgumentException
     * @return mixed
     */
    public static function search($array,$target)
    {
        if(!self::isArray($array)){
            throw new \InvalidArgumentException('Param $array is not array type.');
        }
        return array_search($target,$search);
    }
    
    //NEAD TO DEFINE
    public static function replaceRecursive()
    {
        
    }
    
    public static function getReduce()
    {
        
    }
    
    public static function mergeRecursive()
    {
        
    }
    
    public static function multiSort()
    {
        
    }
    
    
}