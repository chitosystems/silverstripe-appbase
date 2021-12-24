<?php

namespace ChitoSystems\Silverstripe\AppBase\Traits;

use ChitoSystems\Silverstripe\AppBase\Core\SiteManager;
use SilverStripe\Core\Manifest\ModuleResourceLoader;
use SilverStripe\View\ThemeResourceLoader;

trait ThemeFunctions
{


    public static function ProjectDir()
    {

        $projectDir = SiteManager::ResourcePath('app');

        return ModuleResourceLoader::resourceURL($projectDir);
    }

    public function CurrentThemeImageDir()
    {
        return $this->CurrentThemeDir() . '/client/images';
    }


    public static function CurrentThemeDir()
    {
        $themePath = ThemeResourceLoader::inst()->getPath('takunda');

        return ModuleResourceLoader::resourceURL($themePath);
    }


    public static function ActiveThemeDir()
    {
        $themePath = ThemeResourceLoader::inst()->getPath('takunda');

        return ModuleResourceLoader::resourceURL($themePath);
    }


    public static function ConsoleCurrentThemeDir()
    {
        $themePath = ThemeResourceLoader::inst()->getPath('console');

        return ModuleResourceLoader::resourceURL($themePath);
    }


}
