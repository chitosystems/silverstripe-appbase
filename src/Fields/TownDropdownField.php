<?php

namespace ChitoSystems\Silverstripe\AppBase\Forms;


use SilverStripe\Forms\DropdownField;

class TownDropdownField extends DropdownField
{
    public function validate($validator)
    {
        // Check if valid value is given
        $selected = $this->Value();
        $validValues = $this->getValidValues();

        if ( strlen($selected) ) {
            // Use selection rules to check which are valid
            return true;
            /*
            foreach ($validValues as $formValue) {
                if ($this->isSelectedValue($formValue, $selected)) {
                    return true;
                }
            }
            */
        } else {
            if ( $this->getHasEmptyDefault() || !$validValues || in_array('', $validValues) ) {
                // Check empty value
                return true;
            }
            $selected = '(none)';
        }

        // Fail
        $validator->validationError(
            $this->name,
            _t(
                'SilverStripe\\Forms\\DropdownField.SOURCE_VALIDATION',
                "Please select a value within the list provided. {value} is not a valid option",
                [ 'value' => $selected ]
            ),
            "validation"
        );

        return false;
    }

}
