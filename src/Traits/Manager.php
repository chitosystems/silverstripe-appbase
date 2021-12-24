<?php

namespace ChitoSystems\Silverstripe\AppBase\Traits;

use SilverStripe\Core\Config\Configurable;
use SilverStripe\Core\Injector\Injectable;

trait Manager
{
    use Configurable;
    use Injectable;

    /**
     * @param $class
     *
     * @return array
     */
    public static function getObjectMap($class)
    {
        $oObjs = $class::get();

        return $oObjs ? $oObjs->map()->toArray() : [];
    }


    /**
     * Converts decimal longitude / latitude to DMS
     * ( Degrees / minutes / seconds )
     *
     * @param $coord
     *
     * @return string
     */
    public static function DECtoDMS($coord)
    {
        $isnorth = $coord >= 0;
        $coord = abs($coord);
        $deg = floor($coord);
        $coord = ( $coord - $deg ) * 60;
        $min = floor($coord);
        $sec = floor(( $coord - $min ) * 60);

        return sprintf("%d&deg; %d' %d\" %s", $deg, $min, $sec, $isnorth ? 'N' : 'S');
    }
}
    
