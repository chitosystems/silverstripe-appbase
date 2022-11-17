<?php

namespace ChitoSystems\Silverstripe\AppBase\Extensions;

use SilverStripe\Dev\Debug;
use SilverStripe\Forms\CompositeField;
use SilverStripe\Forms\CurrencyField;
use SilverStripe\Forms\DateField;
use SilverStripe\Forms\DropdownField;
use SilverStripe\Forms\EmailField;
use SilverStripe\Forms\NumericField;
use SilverStripe\Forms\PasswordField;
use SilverStripe\Forms\TextareaField;
use SilverStripe\Forms\TextField;
use SilverStripe\Forms\TimeField;
use SilverStripe\ORM\DataExtension;

class FormFieldExtension extends DataExtension
{
    public function onBeforeRender($field)
    {
        $_a = [];
        $_a[] = TextField::class;
        $_a[] = CurrencyField::class;
        $_a[] = DateField::class;
        $_a[] = TimeField::class;
        $_a[] = EmailField::class;
        $_a[] = PasswordField::class;
        $_a[] = TextareaField::class;
        $_a[] = DropdownField::class;
        $_a[] = NumericField::class;

        if ( in_array(get_class($field), $_a) ) {
            $field->addExtraClass('form-control');
        }

    }
}
