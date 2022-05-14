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

}
