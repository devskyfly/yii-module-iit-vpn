<?php
namespace devskyfly\php56\core;

class ExcpErr
{
    const E_ERROR=E_ERROR;
    const E_WARNING=E_WARNING;
    const E_PARSE=E_PARSE;
    const E_NOTICE=E_NOTICE;
    const E_CORE_ERROR=E_CORE_ERROR;
    const E_CORE_WARNING=E_CORE_WARNING;
    const E_COMPILE_ERROR=E_COMPILE_ERROR;
    const E_COMPILE_WARNING=E_COMPILE_WARNING;
    const E_USER_ERROR=E_USER_ERROR;
    const E_USER_WARNING=E_USER_WARNING;
    const E_USER_NOTICE=E_USER_NOTICE;
    const E_STRINCT=E_STRINCT;
    const E_RECOVERABLE_ERROR=E_RECOVERABLE_ERROR;
    const E_DEPRICATED=E_DEPRICATED;
    const E_USER_DEPRICATED=E_USER_DEPRICATED;
    const E_ALL=E_ALL;
    
    /**
     * Return debug back trace in array
     * 
     * @return array
     */
    public static function getDebugBackTrace()
    {
        return debug_backtrace();
    }
    
    public static function cleanLastError()
    {
        error_clean_last();
    }
    
    /**
     * Log error message
     * 
     * @param string $message
     * @param number $message_type
     * @param string $destination
     * @param string $extra_headers
     * @return boolean
     */
    public static function  logError($message,$message_type=0,$destination,$extra_headers)
    {
        $result=false;
        
        if(isset($destination))
        {
            $result=error_log();
        }
        
        if(isset($extra_headers))
        {
            $result=error_log();
        }
        return $result;
    }

    /**
     * Set error level reporting
     * 
     * @param int $level
     * @return int
     */
    public static function  setErrorReportingLevel($level)
    {   
        return error_reporting($level);
    }
    
    /**
     * Get error level reporting
     * 
     * @param int $level
     * @return int
     */
    public static function  getErrorReportingLevel()
    {
        return error_reporting();
    }
    
    /**
     * Set user error handler
     *
     * Handler function have to be void handler(int $level, string $msg[, string $file[,int $line[,context]]])
     *
     * @param string | array $handler
     * @param int $type
     * @return mixed
     */
    public static function setErrorHandler($handler,$type= E_ALL | E_STRICT)
    {
        return set_error_handler($handler,$type);
    }
    
    /**
     * Set exception handler
     * 
     * Handler function have to be void handler(Exception $exc)
     * 
     * @param string $handler - function name
     * @return mixed
     */
    public static function setExceptionHandler($handler)
    {
        return set_exception_handler($handler);
    }
    
    /**
     * Restore previous error handler
     * 
     * @return boolean
     */
    public static function restoreErrorHandler()
    {
        return restore_error_handler();
    }
    
    /**
     * Restore previous exception handler
     *
     * @return boolean
     */
    public static function restoreExceptionHandler()
    {
        return restore_exception_handler();
    }
    
    /**
     * Invoke user error
     * 
     * @param string $msg
     * @param int $type
     * @return boolean
     */
    public static function triggerError($msg,$type=E_USER_NOTICE)
    {
        return trigger_error($msg,$type);
    }
}