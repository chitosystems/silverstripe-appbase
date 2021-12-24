<?php

namespace ChitoSystems\Traits {

    use SilverStripe\Control\Controller;
    use SilverStripe\Core\Convert;
    use SilverStripe\Control\HTTPRequest;
    use Page;
    use PageController;

    trait ControlFunctions
    {

        /**
         * @return array|string
         */
        public function urlParamsParts()
        {
            $oController = $this;
            if ( !( $this instanceof Controller ) ) {
                $oController = Controller::curr();
            }

            return Convert::raw2sql($oController->urlParams);
        }

        public function urlParamsAction()
        {

            return $this->urlParamsParts()[ 'Action' ];
        }

        public function urlParamsID()
        {
            return $this->urlParamsParts()[ 'ID' ];
        }

        public function urlParamsOtherID()
        {
            return $this->urlParamsParts()[ 'OtherID' ];
        }

        /**
         * @return HTTPRequest|null
         */
        public function getControllerRequest(): ?HTTPRequest
        {
            return Controller::curr()->getRequest();
        }


        public function GeneratePageController($title = "Page")
        {

            $tmpPage = new Page();
            $tmpPage->Title = $title;
            $tmpPage->URLSegment = strtolower(str_replace(' ', '-', $title));
            // Disable ID-based caching  of the log-in page by making it a random number
            $tmpPage->ID = -1 * random_int(1, 10000000);

            $controller = PageController::create($tmpPage);
            //$controller->setDataModel($this->model);
            $controller->init();

            return $controller;
        }

    }

}
