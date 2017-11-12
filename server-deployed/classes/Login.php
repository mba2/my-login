<?php
require_once('App.php');
require_once('Api.php');

class Login extends Api {

    private $requiredParameters = array(
        'email',
        'pass',
        'test'
    );
    private $missingParameters = array();

    private $requestMethod;
    private $ajaxParameters;
    private $urlParameters;

    public function __construct() { 
        $this->setRequestMethod();
    }
    
    // PARENT METHODS
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
    
    private function getParameters() {
        $this->urlParameters = $_REQUEST;                               // GET ALL POSSIBLE PARAMETERS PASSED BY URL 
        $this->ajaxParameters = file_get_contents('php://input');       // GET ALL POSSIBLE PARAMETERS PASSED BY AN AJAX CALL
    }

    private function checkRequiredParemetes() {
        // RETRIEVE ALL  MISSING REQUIRED PARAMETERS
        foreach ($this->requiredParameters as $index => $parameter) {
            if( ! array_key_exists($parameter, $this->urlParameters)) {
                $this->missingParameters[] = $parameter;
            }
        }
        // IF ANY OF THEM IS MISSING...
        if( !empty($this->missingParameters)) {
            echo json_encode(
                array(
                    'request type' => $_SERVER['REQUEST_METHOD'], 
                    'status' => 'failure', 
                    'message' => 'You have not passed the following parameter(s): ' . implode(',',$this->missingParameters),
                    'code' => '002'  
                )
            );
            exit();
        }
    }

    private function checkEmptyParameters() {
        // echo "without encode"; 
        // print_r($this->ajaxParameters);
        // echo gettype($this->ajaxParameters);
        // echo "<br>\n\n<br>";
        // echo "with encode"; 
        // print_r(json_encode($this->ajaxParameters));

        print_r(empty($this->ajaxParameters));


        // echo empty($this->ajaxParameters);

        if( empty( $this->urlParameters) && empty($this->ajaxParameters) ){
            echo json_encode(
                array(
                    "request type" => $_SERVER['REQUEST_METHOD'], 
                    "status" => "failure", 
                    "message" => "You have not passed any parameter",
                    'code' => '001'
                )
            );
            exit();
        }
    }
    // PARENT METHODS

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
        $this->getParameters();             // FETCH ALL POSSIBLE GIVEN PARAMETERS
        $this->checkEmptyParameters();      // IF NONE OF THEM WERE PASSED, CLOSE THE SCRIPT AND RESPONDE TO THE USER
        // $this->checkRequiredParemetes();    // IF NONE OF THEM WERE PASSED, CLOSE THE SCRIPT AND RESPONDE TO THE USER
        
        


        // $this->emptyParams();   // CHECKS FOR EMPTY PARAMETERS
        // $this->validParams();   // CHECKS FOR VALID PARAMS
        // $this->signIn();        // LOGS THE USER INTO THE APP 
    }

}