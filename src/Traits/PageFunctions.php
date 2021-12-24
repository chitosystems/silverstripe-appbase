<?php

namespace ChitoSystems\Silverstripe\AppBase\Traits;

use ReflectionException;
use ReflectionClass;
use SilverStripe\ORM\ArrayList;
use SilverStripe\Security\Permission;
use SilverStripe\Security\Security;
use Page;

trait PageFunctions
{


    public static function isSystemUser()
    {
        return Permission::check('SYSTEM_USER');
    }

    public static function isAdmin()
    {
        return Permission::check('ADMIN');
    }

    public function Member()
    {
        return Security::getCurrentUser();
    }

    public function getRawClassName()
    {
        try {
            $reflect = new  ReflectionClass($this->ClassName);

            return $reflect->getShortName();
        } catch ( ReflectionException $e ) {
        }

        return false;
    }

    public function _Link($className)
    {
        if ( class_exists($className) ) {
            $obj = $className::get()->first();

            return ( $obj ) ? $obj->Link() : false;
        }

        return false;
    }


    public function MainMenu()
    {
        return $this->CustomMenu('ShowOnMainMenu');
    }

    public function CustomMenu($mode)
    {

        $visible = [];
        $result = Page::get()->filter([
            $mode => true,
        ]);
        if ( isset($result) ) {
            foreach ( $result as $page ) {
                if ( $page->canView() ) {
                    $visible[] = $page;
                }
            }
        }

        return ArrayList::create($visible);

    }


}
