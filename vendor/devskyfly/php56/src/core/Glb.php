<?php
namespace devskyfly\php56\core;

use devskyfly\php56\types\Vrbl;


/**
 * Give access to super global constants/
 * 
 * In some way this class dublicate Server class.
 * @author devskyfly
 *
 */
class Glb
{
    public static function getGlobals($key=null)
    {
        $arr=$_GLOBALS;
        
        if(Vrbl::isNUll($key)){
            return $arr;
        }else{
            if(isset($arr[$key])){
                return $arr[$key];
            }else{
                return null;
            }
        }
    }
    
    public static function getServer($key=null)
    {
        $arr=$_SERVER;
        
        if(Vrbl::isNUll($key)){
            return $arr;
        }else{
            if(isset($arr[$key])){
                return $arr[$key];
            }else{
                return null;
            }
        }
    }
    
    public static function getGet($key=null)
    {
        $arr=$_GET;
        
        if(Vrbl::isNUll($key)){
            return $arr;
        }else{
            if(isset($arr[$key])){
                return $arr[$key];
            }else{
                return null;
            }
        }
    }
    
    public static function getPost($key=null)
    {
        $arr=$_POST;
        
        if(Vrbl::isNUll($key)){
            return $arr;
        }else{
            if(isset($arr[$key])){
                return $arr[$key];
            }else{
                return null;
            }
        }
    }
    
    public static function getFiles($key=null)
    {
        $arr=$_FILES;
        
        if(Vrbl::isNUll($key)){
            return $arr;
        }else{
            if(isset($arr[$key])){
                return $arr[$key];
            }else{
                return null;
            }
        }
    }
    
    public static function getRequest($key=null)
    {
        $arr=$_REQUEST;
        
        if(Vrbl::isNUll($key)){
            return $arr;
        }else{
            if(isset($arr[$key])){
                return $arr[$key];
            }else{
                return null;
            }
        }
    }
    
    public static function getSession($key=null)
    {
        $arr=$_SESSION;
        
        if(Vrbl::isNUll($key)){
            return $arr;
        }else{
            if(isset($arr[$key])){
                return $arr[$key];
            }else{
                return null;
            }
        }
    }
    
    public static function getEnv($key=null)
    {
        $arr=$_ENV;
        
        if(Vrbl::isNUll($key)){
            return $arr;
        }else{
            if(isset($arr[$key])){
                return $arr[$key];
            }else{
                return null;
            }
        }
    }
    
    public static function getCookie($key=null)
    {
        $arr=$_COOKIE;
        
        if(Vrbl::isNUll($key)){
            return $arr;
        }else{
            if(isset($arr[$key])){
                return $arr[$key];
            }else{
                return null;
            }
        }
    }
    
    public static function getHttpRawPostData($key=null)
    {
        $arr=$HTTP_RAW_POST_DATA;
        
        if(Vrbl::isNUll($key)){
            return $arr;
        }else{
            if(isset($arr[$key])){
                return $arr[$key];
            }else{
                return null;
            }
        }
    }
    
    public static function getHttpResponseHeaders($key=null)
    {
        $arr=$http_response_header;
        
        if(Vrbl::isNUll($key)){
            return $arr;
        }else{
            if(isset($arr[$key])){
                return $arr[$key];
            }else{
                return null;
            }
        }
    }
}