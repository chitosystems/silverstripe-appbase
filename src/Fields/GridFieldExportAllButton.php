<?php

namespace ChitoSystems\Silverstripe\AppBase\Forms;

use SilverStripe\Forms\GridField\GridField;
use SilverStripe\Forms\GridField\GridFieldDataColumns;
use SilverStripe\Forms\GridField\GridFieldExportButton;
use SilverStripe\ORM\DataObject;

class GridFieldExportAllButton extends GridFieldExportButton
{
    /**
     * Return the columns to export
     *
     * @param GridField $gridField
     *
     * @return array|null
     */
    protected function getExportColumnsForGridField(GridField $gridField)
    {

        $model = DataObject::singleton($gridField->getModelClass());

        return method_exists($model, 'exportFields') ? $model->exportFields() : $model->summaryFields();
    }

}
