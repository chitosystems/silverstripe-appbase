<?php

namespace ChitoSystems\Traits {

    use ReflectionException;
    use ReflectionClass;
    use SilverStripe\Core\Manifest\ModuleResourceLoader;
    use SilverStripe\ORM\ArrayList;
    use SilverStripe\ORM\FieldType\DBField;
    use SilverStripe\ORM\FieldType\DBHTMLText;
    use SilverStripe\Security\Permission;
    use SilverStripe\Security\Security;
    use Page;

    trait Utilities
    {

        public static function Guid()
        {
            mt_srand((double)microtime() * 10000);
            $charid = strtolower(md5(uniqid(mt_rand(), true)));
            $hyphen = chr(45);// "-"

            return substr($charid, 0, 8) . $hyphen . substr($charid, 8, 4) . $hyphen . substr($charid, 12, 4) . $hyphen . substr($charid, 16, 4) . $hyphen . substr($charid, 20, 12);
        }

        public static function ResourcePath($module)
        {
            return ModuleResourceLoader::singleton()->resolvePath($module);
        }

        public static function ResourceURL($module)
        {
            return ModuleResourceLoader::singleton()->resolveURL($module);
        }

        public static function addProtocol($url)
        {

            if ( stripos($url, 'https://') !== 0 && stripos($url, 'http://') !== 0 ) {
                return 'https://' . $url;
            }

            return $url;
        }

        public static function removeProtocol($url)
        {
            return preg_replace('(^https?://)', '', $url);

        }


        /**
         * @param string $name
         * @param string $title
         *
         * @return array
         */
        public static function aMonths($name = 'n', $title = 'F')
        {
            $months = [];
            for ( $m = 1; $m <= 12; $m++ ) {
                $timestamp = mktime(0, 0, 0, $m, 1);
                $months[ date($name, $timestamp) ] = date($title, $timestamp);
            }

            return $months;
        }


        /**
         * @param $value
         *
         * @return DBField
         */
        public static function makeHTML($value)
        {
            return DBField::create_field(DBHTMLText::class, $value);
        }

    }

}
