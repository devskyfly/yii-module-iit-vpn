<?php
namespace devskyfly\php56\libs;

class Base64
{
    /**
     * Encode string in base64
     * @param string $val
     * @return string
     */
    public static function encode($val)
    {
        return base64_encode($val);
    }
    
    /**
     * Decode base64 string. Return false on error.
     * @param string $val
     * @return string|false
     */
    public static function decodeStrict($val)
    {
        return base64_decode($val,true);
    }
    
    /**
     * Decode base64 string.
     * @param string $val
     * @return string
     */
    public static function decodeStrinct($val)
    {
        return base64_decode($val);
    }
}