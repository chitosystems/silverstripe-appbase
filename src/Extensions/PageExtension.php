<?php

namespace ChitoSystems\Silverstripe\AppBase\Extensions;

use ReflectionClass;
use ReflectionException;
use SilverStripe\ORM\DataExtension;

/**
 * @property mixed|null $RawClassName
 */
class PageExtension extends DataExtension
{
    private static $db = [];

    private static $casting = [
        'RawClassName' => 'Varchar',
    ];

    public function getRawClassName()
    {
        try {
            $reflect = new  ReflectionClass($this->owner->ClassName);

            return $reflect->getShortName();
        } catch ( ReflectionException $e ) {
        }

        return false;
    }

}
