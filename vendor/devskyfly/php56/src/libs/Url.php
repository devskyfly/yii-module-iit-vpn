<?php
namespace devskyfly\php56\libs;

use devskyfly\php56\types\Vrbl;

class Url
{
    /**
     * Return url query representation of object 
     * 
     * @todo test
     * @param mixed $data
     * @param string $prefix
     * @param string $separartor
     * @return string
     */
    public static function generateQuery($data,$prefix="",$separartor="")
    {
        if(!Vrbl::isEmpty($prefix))  return http_build_query($data,$prefix);
        if(!Vrbl::isEmpty($separartor))  return http_build_query($data,$prefix,$separartor);
        return http_build_query($data);
    }
    
    /**
     * Return parsed url
     * 
     * @todo test
     * @param string $url
     * @throws \Exception
     * @return mixed
     */
    public static function parse($url)
    {
        $result=parse_url($url);
        if($result===false) throw new \Exception('Url parse error.');
        return $result;
    }
    
    /**
     * Return encoded string like application/x-www-form-urlencoded
     * 
     * @todo test
     * @param string $str
     * @return string
     */
    public static function encodeString($str)
    {
        return urlencode($str);
    }
    
    /**
     * Return decode urlencoded string
     * 
     * @todo test
     * @param string $str
     * @return string
     */
    public static function decodeString($str)
    {
        return urldecode($str);
    }

    /**
     * Return encoded string by RFC 3986
     * 
     * @todo test
     * @param $str
     * @return string
     */
    public static function encodeRaw($str)
    {
        return rawurlencode($str);
    }
    
    /**
     * Return decoded string by RFC 3986
     * 
     * @todo test
     * @param $str
     * @return string
     */
    public static function decodeRaw($str)
    {
        return rawurldecode($str);
    }
}