<?php
namespace devskyfly\php56\core;

class Extensions
{
    /**
     * Load neaded extension
     * 
     * @param string $extension
     * @return boolean
     */
    public static function dowload($extension)
    {
        return dl($extension);
    }
    
    /**
     * Define whether extension is loaded
     * 
     * @param string $extension
     * @return boolean
     */
    public static function isLoaded($extension)
    {
        return extension_loaded($extension);
    }
    
    /**
     * Return list of loaded extensions
     * 
     * @return array
     */
    public static function getList()
    {
        return get_loaded_extensions();
    }
    
    /**
     * Return list of loaded Zend extensions
     *
     * @return array
     */
    public static function getZendList()
    {
        return get_loaded_extensions(true);
    }
    
    /**
     * Return list of extension functions
     * 
     * @param string $extension
     * @return array
     */
    public static function getFunctions($extension)
    {
        return get_extension_funcs($extension);
    }
}