<?php
namespace devskyfly\php56\core;

class Info
{
    const PHP_VERSION=PHP_VERSION;
    const PHP_MAJOR_VERSION=PHP_MAJOR_VERSION;
    const PHP_MINOR_VERSION=PHP_MINOR_VERSION;
    const PHP_RELEASE_VERSION=PHP_RELEASE_VERSION;
    const PHP_EXTRA_VERSION=PHP_EXTRA_VERSION;
    const PHP_VERSION_ID=PHP_VERSION_ID;
    const PHP_ZTS=PHP_ZTS;
    const PHP_DEBUG=PHP_DEBUG;
    const PHP_OS=PHP_OS;
    const PHP_EXTENSION_DIR=PHP_EXTENSION_DIR;
    const PHP_PREFIX=PHP_PREFIX;
    const PHP_BINDIR=PHP_BINDIR;
    const PHP_MANDIR=PHP_MANDIR;
    const PHP_LIBDIR=PHP_LIBDIR;
    const PHP_DATADIR=PHP_DATADIR;
    const PHP_SYSCONFDIR=PHP_SYSCONFDIR;
    const PHP_LOCALSTATEDIR=PHP_LOCALSTATEDIR;
    const PHP_CONFIG_FILE_PATH=PHP_CONFIG_FILE_PATH;
    const PHP_CONFIG_FILE_SCAN_DIR=PHP_CONFIG_FILE_SCAN_DIR;
    const PHP_SHLIB_SUFFIX=PHP_SHLIB_SUFFIX;
    const PHP_EOL=PHP_EOL;
    const PHP_MAXPATHLEN=PHP_MAXPATHLEN;
    const PHP_INT_MAX=PHP_INT_MAX;
    const PHP_INT_SIZE=PHP_INT_SIZE;
    const PHP_BINARY=PHP_BINARY;
    const PHP_OUTPUT_HANDLER_START=PHP_OUTPUT_HANDLER_START;
    const PHP_OUTPUT_HANDLER_WRITE=PHP_OUTPUT_HANDLER_WRITE;
    const PHP_OUTPUT_HANDLER_FLUSH=PHP_OUTPUT_HANDLER_FLUSH;
    const PHP_OUTPUT_HANDLER_CLEAN=PHP_OUTPUT_HANDLER_CLEAN;
    const PHP_OUTPUT_HANDLER_FINAL=PHP_OUTPUT_HANDLER_FINAL;
    const PHP_OUTPUT_HANDLER_CONT=PHP_OUTPUT_HANDLER_CONT;
    const PHP_OUTPUT_HANDLER_END=PHP_OUTPUT_HANDLER_END;
    const PHP_OUTPUT_HANDLER_CLEANABLE=PHP_OUTPUT_HANDLER_CLEANABLE;
    const PHP_OUTPUT_HANDLER_FLUSHABLE=PHP_OUTPUT_HANDLER_FLUSHABLE;
    const PHP_OUTPUT_HANDLER_REMOVABLE=PHP_OUTPUT_HANDLER_REMOVABLE;
    const PHP_OUTPUT_HANDLER_STDFLAGS=PHP_OUTPUT_HANDLER_STDFLAGS;
    const PHP_OUTPUT_HANDLER_STARTED=PHP_OUTPUT_HANDLER_STARTED;
    const PHP_OUTPUT_HANDLER_DISABLED=PHP_OUTPUT_HANDLER_DISABLED;
    
    /**
     * Return assosiative array of defined constants
     * 
     * If param categorize is true - answer array is 
     * @param boolean $categorize
     */
    public static function getDefinedConstants($categorize=false)
    {
        return get_defined_constants($categorize);
    }
    
    public static function phpInfo()
    {
        phpinfo();
    }
    
    /**
     * Return php version or extension version
     * 
     * @return string
     */
    public static function phpVersion($extension="")
    {
        $result="";
        if(empty($extension)){
            $result=phpversion($extension);
        }else{
            $result=phpversion($extension);
        }
        return $result;
    }
    
    /**
     * Compare php versions
     * 
     * @param string $version1
     * @param string $version2
     * @return integer -1 | 0 | 1
     */
    public static function versionCompare($version1,$version2)
    {
        return version_compare($version1, $version2, $operator);
    } 
    
    /**
     * Compare php versions by operator
     * @param string $version1
     * @param string $version2
     * @param string $operator
     * @return boolean
     */
    public static function versionCompareByOperator($version1,$version2,$operator)
    {
        return version_compare($version1, $version2, $operator);
    }   
}