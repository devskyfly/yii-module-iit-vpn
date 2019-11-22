<?php
namespace devskyfly\php56\core;

class Ini
{
    public static function getAll($extension="",$details=true)
    {
        return ini_get_all($extension,$details);
    }
    
    /**
     * Return value of php.ini property
     * 
     * Return string, FALSE if the configuration option doesn't exist.
     * @param string $val
     * @return string | false
     */
    public static function get($val)
    {
        return ini_get($val);
    }
    
    /**
     * Set value of php.ini property
     *
     * Return old value on success, FALSE on failure.
     * @param string $property
     * @param string $val
     * @return string | false
     */
    public static function set($property,$val)
    {
        return ini_set($property,$val);
    }
    
    /**
     * Restore prperty to old value
     * 
     * @param string $property
     */
    public static function restore($property)
    {
        ini_restore($property);
    }
}