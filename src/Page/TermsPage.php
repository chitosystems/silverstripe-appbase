<?php

namespace ChitoSystems\CMS {

    use SilverStripe\ORM\DataObject;

    class TermsPage extends LegalPage
    {
        private static $table_name = 'TermsPage';

        /**
         * @param false $action
         *
         * @return mixed
         */
        public static function findLink($action = false)
        {
            if ( !$page = DataObject::get_one(self::class) ) {
                user_error('No TermsPage Page was found. Please create one in the CMS!', E_USER_ERROR);

            }

            return $page->Link($action);
        }


        public function canCreate($member = null, $context = [])
        {
            return !DataObject::get_one(get_class());
        }

    }

}
