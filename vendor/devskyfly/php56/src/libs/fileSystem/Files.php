<?php
namespace devskyfly\php56\libs\fileSystem;

use devskyfly\php56\types\Str;

class Files
{
    /**
     * Delete file.
     * 
     * N.B. Generate E_WARNING error on failure.
     * @param string $path - file name
     * @return boolean
     */
    public static function deleteFile($path)
    {
        if(!Str::isString($path)){
            throw new \InvalidArgumentException('Parameter $path is not string type');
        }
        return unlink($path);
    }
    
    /**
     * Define whether file exists.
     * 
     * @param string $path
     * @return boolean
     */
    public static function fileExists($path)
    {
        return System::exists($path);
    }

    /**
     * Check  is file.
     * 
     * @param string $path
     * @return boolean
     */
    public static function isFile($path)
    {
        if(!Str::isString($path)){
            throw new \InvalidArgumentException('Parameter $path is not string type');
        }
        return is_file($path);
    }
}