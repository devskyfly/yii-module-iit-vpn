<?php
namespace devskyfly\php56\core;

use devskyfly\php56\types\Str;

class Fnc
{
    
    /**
     * Define whether the function exists
     * 
     * @param string $function
     * @throws \InvalidArgumentException
     * @return boolean
     */
    public function exists($function)
    {
        if(!Str::isString($function)){
            throw new \InvalidArgumentException('Param $function is not string type.');
        }
        return function_exists($function_name);
    }
    
    /**
     * Return number of arguments passed to function
     * @return int
     */
    public static function getArgumentsNmb()
    {
        return func_num_args();
    }
    
    /**
     * Return arguments passed to function in array
     * @return array
     */
    public static function getArguments()
    {
        return func_get_args();
    }
    
    /**
     * Return argument passed to function by index
     * @param $index
     * @return mixed
     */
    public static function getArgumentByIndex($index)
    {
        return func_get_arg($index);
    }
}