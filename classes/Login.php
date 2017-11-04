<?php
require_once('App.php');
require_once('Api.php');

class Login extends Api {
    private $userEmail = 'email';
    private $userPass = 'pass';

    public function __construct() { 
        parent::__construct();
    }

    private function logUser2() {
        // empty params


    }

    private function post() {}
    private function get() {}

    private function logUser() {
        // IF THE USER DOESN'T PASS ALL EXPECTED PARAMETERS
        if( !isset( ${$this->requestMethod}["$this->userEmail"])  || !isset( ${$this->requestMethod}["$this->userPass"])) {
            echo json_encode(
                array(  "request type" => $this->requestMethod, 
                        "status" => "failure", 
                        "message" => "Check if you've passed an userEmail and userEmail variables",
                        'code' => '001'
                )
            );
            exit();
        }else {
            $userEmail   = (!empty($_GET['userEmail'])) ? $_GET['userEmail'] : null;
            $userPass   = (!empty($_GET['userPass'])) ? $_GET['userPass'] : null;
            
            if(!$userPass || !$userEmail) {
                echo json_encode(
                    array("request type" => "get", "status" => "failure", "message" => "userEmail or userPass were passed as empty values.")
                );
            }else {
                 //CONNECT TO THE DATABASE//
                $conn = DB::connect();
                // $selectSQL = "SELECT users_id,users_name FROM users_code_help WHERE (users_email = '{$userEmail}') AND (users_pass = '{$userPass}')";
                $selectSQL = "SELECT USERS_ID,USERS_NAME FROM USERS_CODE_HELP WHERE (USERS_EMAIL = '{$userEmail}') AND (USERS_PASS = '{$userPass}')";

                $query = $conn->query($selectSQL);
                //STORE THE RESULT OF AFFECTED ROWS//
                $affectedRows = $query->rowCount();
                //STORE THE RESULT IN AN ARRAY ($result)//
                $result = $query->fetchAll(PDO::FETCH_ASSOC);
                if(!$result) {
                     echo json_encode(
                        array("status" => "failure", "code" => 001 , "message" => "wrong userEmail or userPass")
                    );
                }else {
                    session_start();
                    $_SESSION['aut'] = true;
                    $_SESSION['user'] = $result[0]['USERS_NAME'];
                     echo json_encode(
                        array_merge(
                            array("status" => "success", "code" => 100 , "message" => "User can be authorized"), $result
                        )
                    );
                }
            } 

        }
    }

    public function response() {
        $this->emptyParams();
        // switch($this->requestMethod) {
        //     case 'GET':
        //         $this->logUser();
        //         break;
        //     case 'POST':
        //         echo "POST REQUEST ARE BEIGN DEVELOPED...FOR REAL!";
        //         break;
        //     default:
        //         break;
        // }
    }

}