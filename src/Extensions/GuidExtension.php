<?php

namespace ChitoSystems\Silverstripe\AppBase\Extensions;

use ChitoSystems\Traits\CoreFunctions;
use SilverStripe\Dev\Debug;
use SilverStripe\ORM\DataExtension;
use SilverStripe\Forms\FieldList;
use SilverStripe\Forms\ReadonlyField;
use SilverStripe\ORM\DataList;

/**
 * Class GuidExtension
 *
 * @package ChitoSystems\Extensions
 */
class GuidExtension extends DataExtension
{

    use CoreFunctions;

    /**
     * @var string[]
     */
    private static $db = [
        'Guid' => 'Varchar(255)',
    ];

    /**
     * @param FieldList $fields
     */
    public function updateCMSFields(FieldList $fields)
    {

        //$fields->addFieldToTab('Root.Main', ReadonlyField::create('Guid'));

        $fields->push(ReadonlyField::create('Guid'));
    }

    public function onBeforeWrite()
    {

        if ( empty($this->owner->Guid) ) {
            $this->owner->Guid = $this->generateGuid();
        }

        /*

        $duplicateGuidObjects = DataList::create($this->owner->ClassName)->filter([
            'Guid' => $this->owner->Guid,
        ])->exclude('ID', $this->owner->ID);

        Debug::show($duplicateGuidObjects);

        if ( !count($duplicateGuidObjects)) {
            Debug::show($this->owner->Guid);
            $this->owner->Guid = $this->genetateGuid();
        }
        */

        parent::onBeforeWrite();
    }

    public function requireDefaultRecords()
    {
        parent::requireDefaultRecords();

        if ( $this->owner->hasExtension(__CLASS__) ) {

            $oList = DataList::create($this->owner->ClassName);//->where('Guid IS NULL');
            if ( $oList && $oList->Count() ) {
                foreach ( $oList as $item ) {
                    $item->write();
                }
            }
        }
    }

}

