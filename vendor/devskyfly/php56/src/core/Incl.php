<?php
namespace devskyfly\php56\core;

class Incl
{
    /**
     * Return files names of included files to script
     * 
     * @return array
     */
    public static function getFiles()
    {
        return get_included_files();
    }

    public static function incl($file_path)
    {
        return include($file_path);
    }
    
    public static function inclOnce($file_path)
    {
        return include_once($file_path);
    }
    
    public static function req($file_path)
    {
        return require($file_path);
    }
    
    public static function reqOnce($file_path)
    {
        return require_once($file_path);
    }
}