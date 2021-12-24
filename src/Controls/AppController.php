<?php

namespace ChitoSystems\Silverstripe\AppBase\Controls;

use ChitoSystems\Traits\ControlFunctions;
use ChitoSystems\Traits\CoreFunctions;
use ChitoSystems\Traits\PageFunctions;
use Listings\Store\Categorisation\Collection;
use Listings\Store\Core\StoreManager;
use Listings\Store\Pages\WebPage;
use Listings\Store\StorePage;
use SilverStripe\Control\Controller;
use SilverStripe\Dev\Debug;
use SilverStripe\ORM\DataList;

class AppController extends Controller
{
    use ControlFunctions;
    use PageFunctions;
    use CoreFunctions;

    private static $allowed_actions = [
        'sort_list',
    ];

    public function Link($action = null)
    {

        return "app!/$action";
    }


    public static function findLink($action = false)
    {

        return self::singleton()->Link($action);
    }


    /**
     * @return false|string
     * @throws \JsonException
     * @throws \SilverStripe\ORM\ValidationException
     */
    public function sort_list()
    {
        $aData = $this->getRequestData();

        $className = stripcslashes($aData[ 'sc' ]);
        $id = $aData[ 's' ];

        if ( $className && $id && count($aData[ 'items' ]) ) {

            $oStore = StoreManager::GetByGuid(StorePage::class, $id);
            if ( $oStore ) {
                $aItems = $aData[ 'items' ];
                $i = 1;
                foreach ( $aItems as $item ) {

                    $oItem = DataList::create($className)->filter([
                        'Guid'    => $item,
                        'StoreID' => $oStore->ID,
                    ])->first();

                    if ( $oItem !== null ) {
                        $oItem->Sort = $i;
                        $oItem->write();
                        $i++;
                    }

                }
            }
        }

        return json_encode([
            'status' => 'success',
        ]);

    }

}
