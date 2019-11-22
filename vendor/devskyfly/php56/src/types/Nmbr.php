<?php
namespace devskyfly\php56\types;

class Nmbr
{   
    const NAN=NaN;
    const EPSILON=0.00001;
    const INT_SIZE=PHP_INT_SIZE;
    const INT_MAX=PHP_INT_MAX;
    /**
     * 
     * @param number $val_1
     * @param number $val_2
     * @throws \InvalidArgumentException
     * @return boolean
     */
    public static function isEqual($val_1,$val_2)
    {     
        if(!self::isNumeric($val_1)) 
        {
            throw new \InvalidArgumentException("Param val_1 is not numeric.");
        }
        if(!self::isNumeric($val_2))
        {
            throw new \InvalidArgumentException("Param val_2 is not numeric.");
        }
        
        if(self::toInteger($val_1)&&self::toInteger($val_2))
        {
            if($val_1==$val_2) return true;
        }else{
            $val_1=self::toDouble($val_1);
            $val_2=self::toDouble($val_2);
            if(abs($val_1-$val_2)<self::EPSILON)
            {
                return true;
            }
        }
        
        return false;
    }
    
    /**
     * Define whether the variable is NaN
     *
     * @param float $val
     * @throws \InvalidArgumentException
     * @return boolean
     */
    public static function isNan($val)
    {
        if(!self::isDouble($val)) throw new \InvalidArgumentException('Param val in not float type.');
        return (is_nan($val));
    }
    
    /**
     * Define whether the variable is numeric
     *
     * @param mixed $val
     * @return boolean
     */
    public static function isNumeric($val)
    {
        return (is_numeric($val));
    }
    
    /**
     * Define whether the variable is double
     *
     * @param mixed $val
     * @return boolean
     */
    public static function isDouble($val)
    {
        return (is_double($val));
    }
    
    
    /**
     * Define whether the variable is int
     *
     * @param mixed $val
     * @return boolean
     */
    public static function isInteger($val)
    {
        return (is_Int($val));
    }
    
    /**
     * Convert value to double
     * @param mixed $val
     * @return number
     */
    public static function toDouble($val)
    {
        return floatval($val);
    }
    
    /**
     * Convert value to integer
     * @param mixed $val
     * @return number
     */
    public static function toInteger($val)
    {
        return intval($val);
    }
    
    /**
     * Convert value to double in strict mode
     * @param mixed $val
     * @throws \InvalidArgumentException
     * @return number
     */
    public static function toDoubleStrict($val)
    {
        if(!self::isNumeric($val)) throw new \InvalidArgumentException("Param val is not numeric.");
        return floatval($val);
    }
    
    /**
     * Convert value to integer in strict mode
     * @param mixed $val
     * @throws \InvalidArgumentException
     * @return number
     */
    public static function toIntegerStrict($val)
    {
        if(!self::isNumeric($val)) throw new \InvalidArgumentException("Param val is not numeric.");
        return intval($val);
    }
}