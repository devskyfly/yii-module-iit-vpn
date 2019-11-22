<?php
namespace devskyfly\php56\types;

class Lgc
{
    
    /**
     * Define whether the variable is boolean
     *
     * @param mixed $val
     * @return boolean
     */
    public static function isBoolean($val)
    {
        return is_bool($val);
    }
    
    /**
     * Convert value to bool
     * 
     * @param mixed $val
     * @return boolean
     */
    public static function toBoolean($val)
    {
        return boolval($val);    
    }
}