<?php

namespace ChitoSystems\Silverstripe\AppBase\Extensions;

use ChitoSystems\Silverstripe\AppBase\Core\MobileDetect;
use ChitoSystems\Silverstripe\AppBase\Core\Browser;
use SilverStripe\ORM\DataExtension;

class PageControllerExtension extends DataExtension
{

    /**
     * @return string
     */
    public function BrowserClasses()
    {

        $browser = new Browser();
        $aItems = [];
        $aItems[] = sprintf('Platform_%s', $browser->getPlatform());
        $aItems[] = sprintf('Browser_%s', $browser->getBrowser());

        return implode(' ', $aItems);
    }


    public function isMobile()
    {
        $detect = new MobileDetect();
        if ( $detect->isMobile() ) {
            return true;
        }

        return false;
    }

    public function isTablet()
    {
        $detect = new MobileDetect();
        if ( $detect->isTablet() ) {
            return true;
        }

        return false;
    }

    public function PlatformClasses()
    {

        if ( $this->isMobile() || $this->isTablet() ) {
            return 'mobile';
        }

        return 'desktop';
    }


}
