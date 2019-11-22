<?php
namespace devskyfly\php56\types;

/**
 * 
 * @author devskyfly
 * 
 * Because its imposible to redeclarate:
 * -use isset() to check if variable exists
 * -use unset() to delete variable
 */
class Vrbl
{
    /**
     * Define whether the variable is null
     * 
     * @param mixed $val
     * @return boolean
     */
    public static function isNull($val)
    {
        return is_null($val);
    }
    
    /**
     * Define whether the variable is empty
     *
     * @param mixed $val
     * @return boolean
     */
    public static function isEmpty($val)
    {
        return empty($val);
    }
    
    /**
     * Define whether the variable is scalar
     * 
     * Scalar is a simple type. Array, object, null and resource are not scalar
     * @param mixed $val
     * @since PHP >=7.3
     * @return boolean
     */
    public static function isScalar($val)
    {
        return is_scalar($val);
    }
    
    /**
     * Define whether the variable is iterable variable
     *
     * @param mixed $val
     * @since PHP >=7.3
     * @return boolean
     */
    public static function isIterable($val)
    {
        return is_iterable($val);
    }
    
    /**
     * Define whether the variable is countable variable
     *
     * @param mixed $val
     * @return boolean
     */
    public static function isCountable($val)
    {
        return is_countable($val);
    }
    
    /**
     * Define whether the variable is callable variable
     *
     * @param mixed $val
     * @return boolean
     */
    public static function isCallable($val)
    {
        return is_callable($val);
    }
    
    /**
     * Return the type of PHP variable
     * @param mixed $val
     * @return string boolean, integer, double, string, array, object, resource, NULL, unknown type
     */
    public static function getType($val)
    {
        return gettype($val);
    }
    
    /**
     * 
     * @param mixed $val
     * @param string $type boolean, int, double, string, array, object, null
     * @return boolean
     */
    public static function setType(&$val,$type)
    {
        return settype($val, $type);
    }
    
    
    /**
     * Remove assotion between variable name and its reference
     * @param mixed $val
     */
    public static function unSetIt($val)
    {
        unset($val);
    }
    
    /**
     * Generates a storable representation of value
     * 
     * @param mixed $val
     * @return string
     */
    public static function serialize($val)
    {
        return serialize($val);
    }
    
    /**
     * Create PHP value from a stored representation
     * 
     * @param string $val
     * @return mixed
     */
    public static function unserialize($val)
    {
        return unserialize($val);
    }
    
    /**
     * Display human representation of the variable
     * @param mixed $val
     */
    public static function printR($val)
    {
        return print_r($val);
    }
    
    /**
     * Return human representation of the variable
     * @param mixed $val
     * @return string
     */
    public static function rPrintR($val)
    {
        return print_r($val,true);
    }
    
    /**
     * Displays structured information about variable
     * 
     * @param mixed $val
     */
    public static function varDump($val)
    {
        var_dump($val);
    }
    
    /**
     * Outputs or return parsable string representation of a variable
     * @param mixed $val
     * @param boolean $return
     */
    public static function varExport($val,$return=false)
    {
        return var_export($val,$return);   
    }
    
    /**
     * Return array of defined variables
     * @return array
     */
    public static function getDefined()
    {
        return get_defined_vars();
    }
}