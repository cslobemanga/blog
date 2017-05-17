<?php
namespace Application\Lib;

class Config
{
    
    protected static $settings = [];
    
    /**
     * 
     * @param type $pKey
     * @return type
     */
    public static function get( $pKey )
    {
        return self::$settings[ $pKey ] ?? null;
    }
    
    /**
     * 
     * @param type $pkey
     * @param type $pValue
     */
    public static function set( $pkey, $pValue )
    {
        self::$settings[ $pkey] = $pValue;
    }
}