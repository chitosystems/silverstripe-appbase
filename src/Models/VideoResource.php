<?php

namespace ChitoSystems\Silverstripe\AppBase\Models;

use Page;
use SilverStripe\Assets\File;
use SilverStripe\Core\Injector\Injector;
use SilverStripe\Forms\FileHandleField;
use SilverStripe\ORM\DataObject;

class VideoResource extends DataObject
{
    private static $table_name = 'VideoResource';

    private static $db = [
        'Name'      => 'Varchar(255)',
        'SubTitle'  => 'Varchar(255)',
        'Type'      => 'Enum("video,vimeo,youtube","video")',
        'VideoCode' => 'Varchar',
        'Words'     => 'Text',
        'Sort'      => 'Int',
    ];

    private static $has_one = [
        'Video' => File::class,
        'Page'  => Page::class,
    ];

    private static $owns = [
        'Video',
    ];

    public function getCMSFields()
    {
        $fields = parent::getCMSFields();
        $fields->removeByName([
            'Sort',
            'VideoID',
            'PageID',
        ]);

        $fields->dataFieldByName('Words')->setDescription('Comma separated');

        $video = Injector::inst()->create(FileHandleField::class, 'Video');
        $video->setAllowedFileCategories('video');
        $video->setAllowedMaxFileNumber(1);
        $video->setFolderName('Uploads/Videos/');

        $fields->addFieldToTab('Root.Video', $video);

        return $fields;
    }

    private static $summary_fields = [
        'Name',
    ];

    /**
     * @return bool|string
     */
    public function VideoPath()
    {
        if ( $this->owner->VideoID ) {
            $path = $this->owner->owner->Video()->Link();
            $path_parts = pathinfo($path);

            return $path_parts[ 'dirname' ] . '/' . $path_parts[ 'filename' ];
        }

        return false;
    }

    public function GetScriptWords()
    {

        return $this->owner->Words ?: 'Zimbabwe, awesome,great';

    }

}
