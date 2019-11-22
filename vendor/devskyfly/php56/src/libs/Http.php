<?php
namespace devskyfly\php56\libs;

class Http
{
    /**
     * Return headers as associative array from remote server on request answer
     * 
     * @todo test
     * @param string $url
     * @return array | false
     */
    public static function getHeaders($url)
    {
        return get_headers($url,1);
    }
    
}