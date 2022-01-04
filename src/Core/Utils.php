<?php

namespace ChitoSystems\Silverstripe\AppBase\Core;

use ChitoSystems\Silverstripe\AppBase\Traits\Manager;
use SilverStripe\Core\Config\Configurable;
use SilverStripe\Core\Convert;
use SilverStripe\Core\Extensible;
use SilverStripe\Core\Injector\Injectable;
use SilverStripe\Core\Manifest\ModuleResourceLoader;
use SilverStripe\Forms\GridField\GridFieldAddNewButton;
use SilverStripe\Forms\GridField\GridFieldConfig;
use SilverStripe\Forms\GridField\GridFieldDataColumns;
use SilverStripe\Forms\GridField\GridFieldDeleteAction;
use SilverStripe\Forms\GridField\GridFieldDetailForm;
use SilverStripe\Forms\GridField\GridFieldEditButton;
use SilverStripe\Forms\GridField\GridFieldFooter;
use SilverStripe\Forms\GridField\GridFieldToolbarHeader;
use Symbiote\GridFieldExtensions\GridFieldOrderableRows;

class Utils
{

    use Configurable;
    use Injectable;
    use Extensible;


    /**
     * @param int $x
     * @param int $max
     *
     * @return array
     */
    public static function getNumericValues(int $x = 0, int $max = 4): array
    {
        $aValues = [];
        for ( $i = $x; $i <= $max; $i++ ) {
            $aValues[ $i ] = $i;
        }

        return $aValues;
    }

    /**
     * @param string $name
     * @param string $title
     *
     * @return array
     */
    public static function aMonths(string $name = 'n', string $title = 'F'): array
    {
        $months = [];
        for ( $m = 1; $m <= 12; $m++ ) {
            $timestamp = mktime(0, 0, 0, $m, 1);
            $months[ date($name, $timestamp) ] = date($title, $timestamp);
        }

        return $months;
    }


    /**
     * @param $uuid
     *
     * @return bool
     */
    public static function isValidUuid($uuid): bool
    {

        return !( !is_string($uuid) || ( preg_match('/^[a-f\d]{8}(-[a-f\d]{4}){4}[a-f\d]{8}$/i', $uuid) !== 1 ) );
    }


    public static function getDomain($url)
    {
        $pieces = parse_url($url);
        $domain = $pieces[ 'host' ] ?? '';
        if ( preg_match('/(?P<domain>[a-z0-9][a-z0-9\-]{1,63}\.[a-z\.]{2,6})$/i', $domain, $regs) ) {
            return $regs[ 'domain' ];
        }

        return false;
    }

    /**
     * Converts decimal longitude / latitude to DMS
     * ( Degrees / minutes / seconds )
     *
     * @param $coord
     *
     * @return string
     */
    public static function DECtoDMS( $coord )
    {
        $isnorth = $coord >= 0;
        $coord   = abs( $coord );
        $deg     = floor( $coord );
        $coord   = ( $coord - $deg ) * 60;
        $min     = floor( $coord );
        $sec     = floor( ( $coord - $min ) * 60 );

        return sprintf( "%d&deg; %d' %d\" %s", $deg, $min, $sec, $isnorth ? 'N' : 'S' );
    }

}
