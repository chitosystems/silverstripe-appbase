<?php

namespace ChitoSystems\Silverstripe\AppBase\Forms;

use SilverStripe\Forms\DropdownField;
use SilverStripe\i18n\i18n;
use SilverStripe\Security\Member;
use SilverStripe\Security\Security;

class CountryDropdownField extends DropdownField
{

    /**
     * Should we default the dropdown to the region determined from the user's locale?
     *
     * @var bool
     */
    private static $default_to_locale = true;

    /**
     * The region code to default to if default_to_locale is set to false, or we can't determine a region from a
     * locale
     *
     * @var string
     */
    private static $default_country = 'NZ';

    protected $extraClasses = [ 'dropdown' ];

    /**
     * Get the locale of the Member, or if we're not logged in or don't have a locale, use the default one
     *
     * @return string
     */
    protected function locale()
    {
        if ( ( $member = Security::getCurrentUser() ) && $member->Locale ) {
            return $member->Locale;
        }

        return i18n::get_locale();
    }

    public function __construct($name, $title = null, $source = null, $value = "", $form = null)
    {
        if ( !is_array($source) ) {
            $source = i18n::getData()->getCountries();

            $source = array_combine(array_values($source), array_values($source));

            asort($source);
            $this->hasEmptyDefault = true;
        }

        parent::__construct($name, isset($title) ? $title : $name, $source, $value, $form);
    }

    public function Field($properties = [])
    {
        $source = $this->getSource();

        // Default value to best availabel locale
        $value = $this->Value();
        $this->setValue($value);

        return parent::Field($properties);
    }


}
