<?php

namespace ChitoSystems\Silverstripe\AppBase\Extensions;

use SilverStripe\Core\Config\Config;
use SilverStripe\Forms\FieldList;
use SilverStripe\ORM\DataExtension;
use SilverStripe\ORM\DB;

class SortFieldExtension extends DataExtension
{

    private static $default_sort = 'Sort';

    private static $db = [
        'Sort' => 'Int',
    ];

    /**
     * @param \SilverStripe\Forms\FieldList $fields
     */
    public function updateCMSFields(FieldList $fields)
    {
        $fields->removeByName([
            'Sort',
        ]);

    }

    /*
    public function onBeforeWrite()
    {
        if ( null === $this->owner->Sort ) {
            $table = $this->GetTableName();
            $maxSort = DB::query(
                "SELECT MAX(\"Sort\") FROM \"$table\" "
            )->value();
            $this->owner->Sort = (int)$maxSort + 1;
        }
    }

    public function GetTableName()
    {

        return Config::inst()->get($this->owner->ClassName, 'table_name', Config::UNINHERITED);
    }
    */
}
