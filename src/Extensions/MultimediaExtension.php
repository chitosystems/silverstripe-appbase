<?php

namespace ChitoSystems\Silverstripe\AppBase\Extensions;

use ChitoSystems\Silverstripe\AppBase\Models\Multimedia;
use Colymba\BulkUpload\BulkUploader;
use SilverStripe\Dev\Debug;
use SilverStripe\Forms\FieldList;
use SilverStripe\Forms\GridField\GridField;
use SilverStripe\Forms\GridField\GridFieldConfig_RecordEditor;
use SilverStripe\ORM\DataExtension;
use SilverStripe\ORM\DataList;
use Symbiote\GridFieldExtensions\GridFieldOrderableRows;
use UndefinedOffset\SortableGridField\Forms\GridFieldSortableRows;

class MultimediaExtension extends DataExtension
{

    private static $has_many = [
        'Images' => Multimedia::class,
    ];

    /**
     * @param FieldList $fields
     */
    public function updateCMSFields(FieldList $fields)
    {
        $ImagesGridFieldConfig = GridFieldConfig_RecordEditor::create();
        $ImagesGridFieldConfig->addComponent(new  BulkUploader());
        $ImagesGridFieldConfig->addComponent(new GridFieldOrderableRows('Sort'));
        $ImagesGridFieldConfig->getComponentByType(BulkUploader::class)
            ->setUfSetup('setFolderName', 'Uploads/multimedia/' . $this->owner->URLSegment);

        $fields->addFieldToTab('Root.Images', new GridField('Images', 'Images', $this->owner->Images(), $ImagesGridFieldConfig));


    }

    public function Image()
    {
        if ( method_exists($this->owner, 'HeroImage') ) {
            return $this->owner->HeroImage();
        }
        if ( count($this->owner->Images()) ) {
            $image = $this->owner->Images()->first();

            return $image->Image();
        }


        return false;
    }

    public function RandomImage()
    {
        if ( count($this->owner->Images()) ) {
            $image = $this->owner->Images()->sort('Rand()')->first();

            return $image->Image();
        }

        return false;
    }


    public function getRawClassName()
    {
        $reflect = new \ReflectionClass($this->owner->ClassName);

        return $reflect->getShortName();
    }

    public function GetObjectImages()
    {

        $aImages = [];

        if ( count($this->owner->Images()) ) {
            $oImages = $this->owner->Images();

            $oImages = $oImages->exclude('ID', $oImages->first()->ID)->sort('Rand()')->limit(10);

            foreach ( $oImages as $multimedia ) {
                $multimedia->write();
                $aMultimedia = [
                    'ID'                            => $multimedia->ID,
                    $this->getRawClassName() . 'ID' => $this->owner->ID,
                ];
                if ( $multimedia->getImageLink() ) {
                    $aMultimedia[ 'ImageFilename' ] = $multimedia->getImageLink();
                } else {
                    $aMultimedia[ 'ImageFilename' ] = $multimedia->Image()->FillMax(800, 600)->URL;
                }


                $aImages[] = $aMultimedia;

            }

        }

        return $aImages;

    }
}
