<?php

namespace ChitoSystems\Silverstripe\AppBase\Extensions;

use SilverStripe\Core\Extension;

class TabExtension extends Extension
{

    /**
     * @var bool
     */
    protected $IsFullWidth = false;

    /**
     * @var
     */
    protected $icon;


    /**
     * @return mixed
     */
    public function getIcon()
    {
        return $this->owner->icon;
    }

    /**
     * @param $icon
     *
     * @return Object
     */
    public function setIcon($icon)
    {
        $this->owner->icon = $icon;

        return $this->owner;
    }

    public function setIsFullWidth(bool $IsFullWidth)
    {
        $this->owner->IsFullWidth = $IsFullWidth;

        return $this->owner;
    }


    public function getIsFullWidth()
    {
        return Config::inst()->get($this->owner,'IsFullWidth');

        //return $this->owner->IsFullWidth;
    }

}
