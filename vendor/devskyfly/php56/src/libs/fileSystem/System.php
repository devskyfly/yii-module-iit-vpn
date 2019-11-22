<?php
namespace devskyfly\php56\libs\fileSystem;

use devskyfly\php56\types\Str;

class System
{
    /**
     *
     * @param string $path
     * @return boolean
     */
    public static function exists($path)
    {
        if(!Str::isString($path)){
            throw new \InvalidArgumentException('Parameter $path is not string type');
        }
        $real_path=realpath($path);
        return file_exists($real_path);
    }
    
    /**
     * Check  is link.
     *
     * @param string $path
     * @return boolean
     */
    public static function isLink($path)
    {
        if(!Str::isString($path)){
            throw new \InvalidArgumentException('Parameter $path is not string type');
        }
        return is_link($path);
    }
    
    /**
     * Return files and directories by pattern.
     *
     * @param string $pattern
     * @return []
     */
    public static function getFilesByPattern($pattern)
    {
        if(!Str::isString($pattern)){
            throw new \InvalidArgumentException('Parameter $pattern is not string type');
        }
        return glob($pattern);
    }
}