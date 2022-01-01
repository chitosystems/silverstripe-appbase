<?php

namespace ChitoSystems\Silverstripe\AppBase\Extensions;

use SilverStripe\CMS\Forms\SiteTreeURLSegmentField;
use SilverStripe\CMS\Model\SiteTree;
use SilverStripe\Control\Controller;
use SilverStripe\Control\Director;
use SilverStripe\Dev\Debug;
use SilverStripe\Forms\FieldList;
use SilverStripe\Forms\ReadonlyField;
use SilverStripe\ORM\DataExtension;
use SilverStripe\ORM\DataList;

class ConsoleObjectURLSegmentExtension extends DataExtension
{

    private static $db = [
        'URLSegment' => 'Varchar(200)',
    ];

    private static $indexes = [
        "URLSegment" => true,
    ];

    public function BaseLink_()
    {
        user_error('Please implement ' . __FUNCTION__ . ' method in your model', E_USER_WARNING);
    }

    /**
     * @param FieldList $fields
     */
    public function updateCMSFields(FieldList $fields)
    {
        $baseLink = false;
        if ( method_exists($this->owner, 'baseLink') ) {
            $baseLink = Controller::join_links(Director::absoluteBaseURL(), $this->owner->baseLink());
            if ( !empty($baseLink) ) {

                $urlSegment = SiteTreeURLSegmentField::create('URLSegment')->setURLPrefix($baseLink)->setURLSuffix('/');
                $before = null;

                if ( $fields->dataFieldByName('Name') ) {
                    $before = 'Name';
                } elseif ( $fields->dataFieldByName('Content') ) {
                    $before = 'Content';
                }

                $fields->addFieldToTab("Root.Main", $urlSegment, $before);

            }
        }

        if ( !$baseLink ) {
            $fields->addFieldToTab("Root.Main", ReadonlyField::create("URLSegment"));
        }


    }

    public function AbsoluteLink()
    {
        return Director::absoluteURL($this->owner->Link());
    }


    public function MenuTitle()
    {
        return $this->owner->getField("Title");
    }

    public function onBeforeWrite()
    {

        $name = $this->owner->Title ?: $this->owner->Name;
        $this->owner->URLSegment = $this->generateUniqueURLSegment($name);

        parent::onBeforeWrite();
    }

    /*
    * Generate Unique URLSegment
    */
    public function generateUniqueURLSegment($title)
    {
        $URLSegment = singleton(SiteTree::class)->generateURLSegment($title);
        $prevurlsegment = $URLSegment;
        $i = 1;
        while ( !$this->validURLSegment($URLSegment) ) {
            $URLSegment = $prevurlsegment . "-" . $i;
            $i++;
        }

        return $URLSegment;

    }

    public function validURLSegment($URLSegment)
    {

        $anchorClassName = method_exists($this->owner, 'AnchorClassName') ? $this->owner->AnchorClassName() : $this->owner->ClassName;
        $existingPage = DataList::create($anchorClassName)->filter([
            'URLSegment' => $URLSegment,
            'StoreID'    => $this->owner->StoreID,
        ])->exclude([
            'ID' => $this->owner->ID,
        ])->first();

        if ( $existingPage ) {
            return false;
        }

        return true;
    }
}
