<?php

namespace ChitoSystems\Silverstripe\AppBase\Controls;

use ChitoSystems\Silverstripe\AppBase\Traits\ControlFunctions;
use ChitoSystems\Silverstripe\AppBase\Traits\CoreFunctions;
use ChitoSystems\Silverstripe\AppBase\Traits\PageFunctions;
use SilverStripe\Control\Controller;
use SilverStripe\Dev\Debug;
use SilverStripe\ORM\DataList;

class AppController extends Controller
{
    use ControlFunctions;
    use PageFunctions;

    private static $allowed_actions = [];

    public function Link($action = null)
    {

        return "app!/$action";
    }

    public static function findLink($action = false)
    {
        return self::singleton()->Link($action);
    }



}
