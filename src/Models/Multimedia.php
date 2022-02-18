<?php

namespace ChitoSystems\Silverstripe\AppBase\Models;

use ChitoSystems\Geo\Models\Country;
use ChitoSystems\Geo\Models\Province;
use ChitoSystems\Geo\Models\Town;
use SilverStripe\Assets\Image;
use SilverStripe\Core\Injector\Injector;
use SilverStripe\Forms\FileHandleField;
use SilverStripe\ORM\DataObject;

/**
 * @property mixed|null $ImageID
 * @method Image Image()
 * @method DataObject Owner()
 */
class Multimedia extends DataObject
{
    private static $table_name = 'Multimedia';

    private static $default_sort = 'Sort';

    private static $db = [
        'Name'    => 'Varchar(255)',
        'Content' => 'Text',
        'Sort'    => 'Int',
    ];

    private static $has_one = [
        'Image' => Image::class,
        'Owner' => DataObject::class,
    ];

    private static $owns = [
        'Image',
    ];

    private static $cascade_deletes = [
        'Image',
    ];

    /**
     * @return \SilverStripe\Forms\FieldList
     */
    public function getCMSFields()
    {
        $fields = parent::getCMSFields();
        $fields->removeByName([
            'OwnerID',
        ]);

        $bannerImage = Injector::inst()->create(FileHandleField::class, 'Image');
        $bannerImage->setAllowedFileCategories('image/supported');
        $bannerImage->setAllowedMaxFileNumber(1);
        $bannerImage->setFolderName('Uploads/multimedia/' . $this->Owner()->URLSegment);

        $fields->addFieldsToTab('Root.MultiMedia', [
            $bannerImage,
        ]);

        return $fields;
    }

    private static $summary_fields = [
        'Thumbnail',
        'Name',
    ];

    public function getThumbnail()
    {
        $image = $this->Image();
        if ( $image && $image->ID ) {
            return $image->CMSThumbnail();
        }
    }

    public function onAfterWrite()
    {
        parent::onAfterWrite();

        if ( $this->ImageID ) {
            $this->Image()->publishRecursive();
        }


    }

}
