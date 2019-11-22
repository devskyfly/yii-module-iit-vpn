<?php
namespace devskyfly\php56\core;

class Process
{
    /**
     * Return process id
     * 
     * @return number
     */
    public static function getPid()
    {
        return getmypid();
    }
}