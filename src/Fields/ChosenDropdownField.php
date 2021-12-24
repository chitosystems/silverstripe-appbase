<?php

namespace ChitoSystems\Silverstripe\AppBase\Forms;

use SilverStripe\Forms\DropdownField;

class ChosenDropdownField extends DropdownField
{

    public function __construct($name, $title = null, $source = [], $value = null)
    {
        $this->extraClasses[] = 'chosen-select';
        parent::__construct($name, $title, $source, $value);
    }

}
