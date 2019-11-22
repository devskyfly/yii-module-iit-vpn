<?php
namespace devskyfly\php56\libs\fileSystem;

use devskyfly\php56\types\Str;

class Dirs
{

    /**
     * Delete dir only if empty.
     * 
     * N.B. Generate E_WARNING error on failure.
     * @param string $path
     * @return boolean
     */
    public static function deleteDir($path)
    {
        if(!Str::isString($path)){
            throw new \InvalidArgumentException('Parameter $path is not string type');
        }
        return rmdir($path);
    }
    
    /**
     * Delete dir recursively.
     *
     * N.B. Generate E_WARNING error on failure.
     * @param string $path
     * @return boolean
     */
    public static function deleteDirR($path)
    {
        if(!Str::isString($path)){
            throw new \InvalidArgumentException('Parameter $path is not string type');
        }
        
        $files = array_diff(scandir($path), array('.','..'));
        foreach ($files as $file) {
            (is_dir("$path/$file")) ? self::deleteDirR("$path/$file") : unlink("$path/$file");
        }
        return rmdir($path);
    }
    
    /**
     * Define whether file exists.
     * 
     * @param string $path
     * @return boolean
     */
    public static function dirExists($path)
    {
        return System::exists($path);
    }
    

    /**
     * Check is dir.
     * 
     * @param string $path
     * @return boolean
     */
    public static function isDir($path)
    {
        if(!Str::isString($path)){
            throw new \InvalidArgumentException('Parameter $path is not string type');
        }
        return is_dir($path);
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
    
    /**
     * List files and directories inside $path
     * 
     * N.B. Generate E_WARNING error on failure.
     * @param string $path
     * @throws \InvalidArgumentException
     * @return array
     */
    public static function scanDir($path)
    {
        if(!Str::isString($path)){
            throw new \InvalidArgumentException('Parament $path is not string type');
        }
        return scandir($path);
    }
}