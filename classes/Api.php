<?php
require_once("App.php");
require_once("Api.php");

class Api extends App {

    protected $requestMethod;
    
    public function __construct() {
        $this->setRequestMethod();
    }

    protected function emptyParams() {
        $viaURL = empty($_REQUEST);                                 // CHECKS IF ANY PARAMETER WAS PASSED BY URL 
        $viaAJAX = empty( file_get_contents('php://input') );       // CHECKS IF ANY PARAMETER WAS PASSED BY AN AJAX CALL

        // IF NONE OF THEM WERE PASSED...
        if( $viaURL && $viaAJAX){
            echo json_encode(
                array(
                    "request type" => $_SERVER['REQUEST_METHOD'], 
                    "status" => "failure", 
                    "message" => "You have not passed any parameter",
                    'code' => '001'
                )
            );
        } 
        return false;
    }

    private function setRequestMethod() {
        switch ($_SERVER['REQUEST_METHOD']) {
            case 'GET':
                $this->requestMethod = &$_GET;
                break;
            case 'POST':
                $this->requestMethod = &$_POST;
                break;
            default:
                $this->requestMethod = &$_GET;
        }
    }

    private function getRequestMethod() {
        return $this->requestMethod;
    }

    // abstract function response();
}