<?php
namespace devskyfly\php56\core;

class GbCollector
{
    /**
     * Start garbage collector
     * 
     * Return number of links
     * @return integer
     */
    public static function start()
    {
        return gc_enable();
    }
    
    /**
     * Enable garbage collector
     */
    public static function enable()
    {
        gc_enable();
    }
    
    /**
     * Disable garbage collector
     */
    public static function disable()
    {
        gc_disable();
    }
    
    /**
     * Return garbage collector status
     * 
     * @return boolean
     */
    public static function status()
    {
        return gc_enabled();
    }
}