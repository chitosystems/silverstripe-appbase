<?php

namespace ChitoSystems\Silverstripe\AppBase\Extensions;

use SilverStripe\ORM\DataExtension;
use ReflectionClass;
use ReflectionException;

/**
 * @property mixed|null $RawClassName
 */
class DataObjectExtension extends DataExtension
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
