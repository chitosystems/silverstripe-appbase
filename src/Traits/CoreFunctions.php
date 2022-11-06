<?php

namespace ChitoSystems\Silverstripe\AppBase\Traits;

use ChitoSystems\Silverstripe\AppBase\Core\SiteManager;
use SilverStripe\Core\Config\Config;
use SilverStripe\ORM\FieldType\DBDatetime;
use SilverStripe\Security\Member;
use SilverStripe\Core\Convert;

trait CoreFunctions
{

    /**
     * @param        $phone
     * @param string $oCountry
     *
     * @return string
     */
    public function sanitiseCountryPhoneNumber($phone, $oCountry = ''): string
    {
        $phoneNumber = preg_replace('/[\D]/', '', $phone);

        if ( !empty($oCountry) ) {
            $code = $oCountry->PhoneCode;
            $phoneNumber = str_replace($code, '', $phoneNumber);

            return $code . substr($phoneNumber, -9);
        }

        return '0' . substr($phoneNumber, -9);
    }


    /**
     * @param $uuid
     *
     * @return bool
     */
    public static function isValidUuid($uuid): bool
    {

        if ( !is_string($uuid) || ( preg_match('/^[a-f\d]{8}(-[a-f\d]{4}){4}[a-f\d]{8}$/i', $uuid) !== 1 ) ) {
            return false;
        }

        return true;
    }

    /**
     * @param $class
     *
     * @return mixed
     */
    public static function GetTableName($class)
    {

        return Config::inst()->get($class, 'table_name', Config::UNINHERITED);
    }

    /**
     * @param $phone
     *
     * @return string
     */
    public static function SanitisePhoneNumber($phone): string
    {
        $phoneNumber = preg_replace('/[\D]/', '', $phone);

        return '+27' . substr($phoneNumber, -9);
    }


    public static function getDBDatetime(): string
    {

        return DBDatetime::now()->Rfc2822();
    }

    /**
     * @param int $x
     * @param int $max
     *
     * @return array
     */
    public function getNumericValues($x = 0, $max = 4)
    {

        $arrValues = [];
        for ( $i = $x; $i <= $max; $i++ ) {
            $arrValues[ $i ] = $i;
        }

        return $arrValues;
    }

    /**
     *
     * Get list of all members you have the "Full administrative right" permission
     *
     * @return \SilverStripe\ORM\DataList
     */
    public static function getAdminList()
    {

        return Member::get()->leftJoin('Group_Members', 'Group_Members.MemberID = Member.ID')
            ->leftJoin('Permission', 'Permission.GroupID = Group_Members.GroupID')
            ->filter([ 'Code' => 'ADMIN' ]);

    }

    public function genetateGuid()
    {
        return $this->generateGuid();
    }

    /**
     * @return string
     */
    public function generateGuid(): string
    {
        mt_srand((double)microtime() * 10000);
        $charid = strtolower(md5(uniqid(mt_rand(), true)));
        $hyphen = chr(45);// "-"

        return substr($charid, 0, 8) . $hyphen . substr($charid, 8, 4) . $hyphen . substr($charid, 12, 4) . $hyphen . substr($charid, 16, 4) . $hyphen . substr($charid, 20, 12);
    }

    /**
     * @param null $query
     *
     * @return array|false|mixed|string
     */
    protected function getRequestData($query = null)
    {

        $data = $this->request->requestVars();
        $aData = SiteManager::cleanREQUEST($data);
        if ( $query ) {

            return $aData[ $query ] ?? false;
        }

        return $aData;

    }

    public function CleanContent($raw_content)
    {
        $content = stripcslashes($raw_content);
        if ( $content ) {

            $content = str_replace([
                "\\r\\n",
                "\\r",
                "\\n",
            ], ' ', $content);

            return DBField::create_field('HTMLFragment', $content);
        }

        return '';

    }

    /**
     * @param array $aResponse
     *
     * @return false|string
     * @throws \JsonException
     */
    protected function jsonResponseData(array $aResponse)
    {
        return json_encode($aResponse);
    }


}
