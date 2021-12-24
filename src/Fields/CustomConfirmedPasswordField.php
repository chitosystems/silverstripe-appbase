<?php

namespace ChitoSystems\Silverstripe\AppBase\Forms;


use SilverStripe\Forms\ConfirmedPasswordField;

class CustomConfirmedPasswordField extends ConfirmedPasswordField
{
    public function setChildrenPlaceholders($titles)
    {
        if ( is_array($titles) && count($titles) == 2 ) {
            foreach ( $this->children as $field ) {
                if ( isset($titles[ 0 ]) ) {
                    $field->setAttribute('placeholder', $titles[ 0 ]);
                    array_shift($titles);
                }
            }
        }

        return $this;
    }
}
