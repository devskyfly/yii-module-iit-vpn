<?php
namespace devskyfly\php56\core;

use devskyfly\php56\types\Vrbl;

/**
 * Can't redeclarate using magic constants like:
 *  __TRAIT__
 *  __METHOD__
 *  __NAMESPACE__
 *  __CLASS__
 * Use them separatly.
 * @author devskyfly
 *
 */
 class Cls
 {
     /**
      * Check if trait exists
      *
      * @param string $traitname
      * @throws \Exception
      * @return boolean
      */
     public static function traitExists($trait_name)
     {
         $result=trait_exists($trait_name);
         if(Vrbl::isNull($result)) throw new \Exception("Trait existing check error.");
         return $result;
     }
     
     /**
      * Check if class exists
      *
      * @param string $class_name
      * @return boolean
      */
     public static function classExists($class_name)
     {
         return class_exists($traitname);
     }
     
     
     /**
      * Check if property exists
      *
      * @param string|object $class_obj
      * @param string $property
      * @throws \Exception
      * @return boolean
      */
     public static function classPropertyExists($class_obj,$property)
     {
         $result=property_exists($class_obj,$property);
         if(Vrbl::isNull($result)) throw new \Exception("Property existing check error.");
         return $result;
     }
     
     /**
      * Check if method exists
      *
      * @param string|object $class_obj
      * @param string $property
      * @throws \Exception
      * @return boolean
      */
     public static function classMethodExists($class_obj,$property)
     {
         $result=property_exists($class_obj,$property);
         if(Vrbl::isNull($result)) throw new \Exception("Property existing check error.");
         return $result;
     }
    
     /**
      * Define whether the class or object is sub class of target class
      *
      * @param object|string $object - object or class name
      * @param string $class_name
      */
     public static function isSubClassOf($object,$class_name)
     {
         return is_subclass_of($object, $class_name);
     }
 }