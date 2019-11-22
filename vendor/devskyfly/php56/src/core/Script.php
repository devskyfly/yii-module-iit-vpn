<?php
namespace devskyfly\php56\core;

class Script
{
    /**
     * Return user name of current script owner
     * 
     * @return string
     */
    public static function getUserName()
    {
        return get_current_user();
    }
    
    /**
     * Return user id of current script
     *
     * @return int | false
     */
    public static function getUid()
    {
        return getmyuid();
    }
    
    /**
     * Return inode of current script
     * 
     * @return int | false
     */
    public static function getINode()
    {
        return getinode();
    }
    
    /**
     * Return date of lust modification of cerrent script
     * 
     * @return number
     */
    public static function getLastMod()
    {
        return getlastmod();
    }
}
