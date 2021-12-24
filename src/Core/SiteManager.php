<?php

namespace ChitoSystems\Silverstripe\AppBase\Core;

use ChitoSystems\Traits\Manager;
use SilverStripe\Core\Convert;
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

class SiteManager
{

    use Manager;

    public static function ResourcePath($module)
    {
        return ModuleResourceLoader::singleton()->resolvePath($module);
    }

    public static function ResourceURL($module)
    {
        return ModuleResourceLoader::singleton()->resolveURL($module);
    }


    /**
     * @param string $sortField
     *
     * @return GridFieldConfig
     */
    public static function getGridFieldConfig($sortField = 'Sort')
    {
        $oConfig = GridFieldConfig::create();
        $oConfig->addComponent(new GridFieldToolbarHeader());
        $oConfig->addComponent(new GridFieldAddNewButton('toolbar-header-right'));
        $oConfig->addComponent(new GridFieldDataColumns());
        $oConfig->addComponent(new GridFieldDetailForm());
        $oConfig->addComponent(new GridFieldEditButton());
        $oConfig->addComponent(new GridFieldDeleteAction());
        if ( $sortField ) {
            $oConfig->addComponent(new GridFieldOrderableRows($sortField));
        }
        $oConfig->addComponent(new GridFieldFooter(null, false));

        return $oConfig;
    }


    public static function addProtocol($url)
    {

        if ( stripos($url, 'https://') !== 0 && stripos($url, 'http://') !== 0 ) {
            return 'https://' . $url;
        }

        return $url;
    }

    public static function removeProtocol($url)
    {
        return preg_replace('(^https?://)', '', $url);

    }

    /**
     * @param       $request
     * @param array $Unset
     *
     * @return array|string
     */
    public static function cleanREQUEST($request, array $Unset = [])
    {

        $request = Convert::raw2sql($request);
        if ( $request ) {


            $aUnset = [
                'url',
                'SecurityID',
            ];
            $arrUnset = array_merge($aUnset, $Unset);
            foreach ( $arrUnset as $value ) {
                unset($request[ $value ]);
            }
        }

        return $request;
    }


    public static function CleanTinyContent($string)
    {
        // remove unwanted style propeties
        $except = [ 'color', 'font-weight', 'font-size', 'height', 'width' ]; // declare your exceptions
        $allow = implode($except, '|');
        $regexp = '@([^;"]+)?(?<!' . $allow . '):(?!\/\/(.+?)\/)((.*?)[^;"]+)(;)?@is';
        //$string = preg_replace($regexp, '', $string);
        //$string = preg_replace('@[a-z]*=""@is', '', $string); // remove any unwanted style attributes
        $regexp = '@([^;"]+)?(?<!' . $allow . '):(?!\/\/(.+?)\/)((.*?)[^;"]+)(;)?@is';//this line should be replaced with other gibberish that excludes certain strings of 4 characters...
        $string = preg_replace($regexp, '', $string);
        // remove unwanted style propeties end
        $string = str_replace(' style=""', '', $string);

        return $string;
    }


}
