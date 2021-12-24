<?php

namespace ChitoSystems\CMS {

    use SilverStripe\ORM\DataObject;
    use Page;

    class ContactPage extends Page
    {
        private static $table_name = 'ContactPage';

        public static function findLink($action = false)
        {
            if ( !$page = DataObject::get_one(self::class) ) {
                user_error('No ContactPage Page was found. Please create one in the CMS!', E_USER_ERROR);

            }

            return $page->Link($action);
        }


        public function canCreate($member = null, $context = [])
        {
            return !DataObject::get_one(get_class());
        }

    }

}
