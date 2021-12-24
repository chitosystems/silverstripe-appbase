<?php

namespace ChitoSystems\Silverstripe\AppBase\Forms;

use SilverStripe\Forms\FormAction;
use SilverStripe\View\HTML;

class DeleteFormAction extends FormAction
{

    /**
     * @var string
     */
    private $link;

    public function __construct($link = '', $title = '')
    {
        if ( !$title ) {
            $title = _t('DeleteFormAction.DELETE', 'Delete');
        }

        $this->setLink($link);

        parent::__construct('DeleteFormAction', $title);
    }

    function setLink($link)
    {
        $this->link = $link;

        return $this;
    }

    function getLink()
    {
        return $this->link;
    }


    /**
     * @return array
     */
    public function getAttributes()
    {

        $attributes = [];


        return array_merge(
            parent::getAttributes(),
            $attributes
        );
    }


    public function Field($properties = [])
    {
        $attributes = [
            'class'    => 'DeleteFormAction btn btn-danger delete-action ' . ( $this->extraClass() ?: '' ),
            'id'       => $this->id(),
            'name'     => $this->action,
            'tabindex' => $this->getAttribute('tabindex'),
            'href'     => $this->getLink(),
        ];

        if ( $this->isReadonly() ) {
            $attributes[ 'disabled' ] = 'disabled';
            $attributes[ 'class' ] .= ' disabled';
        }
        if ( count($this->attributes) ) {
            foreach ( $this->attributes as $name => $value ) {
                $attributes[ $name ] = $value;

            }
        }

        return HTML::createTag('a', $attributes, $this->buttonContent ?: $this->Title());
    }
}
