<?php

require_once("../../classes/Login.php");


// $test = "_GET";

// print_r($$test);

$Login = new Login();
$Login->response();

// function logUser() {
//         if( !isset( $_GET['userEmail'])  || !isset( $_GET['userPass'])) {
//             echo json_encode(
//                 array("request type" => "get", "status" => "failure", "message" => "Check if you've passed an userEmail and userEmail variables")
//             );
//             exit();
//         }else {
//             $userEmail   = (!empty($_GET['userEmail'])) ? $_GET['userEmail'] : null;
//             $userPass   = (!empty($_GET['userPass'])) ? $_GET['userPass'] : null;
            
//             if(!$userPass || !$userEmail) {
//                 echo json_encode(
//                     array("request type" => "get", "status" => "failure", "message" => "userEmail or userPass were passed as empty values.")
//                 );
//             }else {
//                  //CONNECT TO THE DATABASE//
//                 $conn = DB::connect();
//                 // $selectSQL = "SELECT users_id,users_name FROM users_code_help WHERE (users_email = '{$userEmail}') AND (users_pass = '{$userPass}')";
//                 $selectSQL = "SELECT USERS_ID,USERS_NAME FROM USERS_CODE_HELP WHERE (USERS_EMAIL = '{$userEmail}') AND (USERS_PASS = '{$userPass}')";

//                 $query = $conn->query($selectSQL);
//                 //STORE THE RESULT OF AFFECTED ROWS//
//                 $affectedRows = $query->rowCount();
//                 //STORE THE RESULT IN AN ARRAY ($result)//
//                 $result = $query->fetchAll(PDO::FETCH_ASSOC);
//                 if(!$result) {
//                      echo json_encode(
//                         array("status" => "failure", "code" => 001 , "message" => "wrong userEmail or userPass")
//                     );
//                 }else {
//                     session_start();
//                     $_SESSION['aut'] = true;
//                     $_SESSION['user'] = $result[0]['USERS_NAME'];
//                      echo json_encode(
//                         array_merge(
//                             array("status" => "success", "code" => 100 , "message" => "User can be authorized"), $result
//                         )
//                     );
//                 }
//             } 

//         }
// }


$method = $_SERVER["REQUEST_METHOD"];

// echo "<pre>";
// echo "REQUEST METHOD: {$method} <br/>";
// echo "GET ". print_r($_GET) . "<br/><br/><br/><br/><br/>";



// switch($method) {
//     case 'GET':
//         logUser();
//         break;
//     case 'POST':
//         echo "POST REQUEST ARE BEIGN DEVELOPED...FOR REAL!";
//         break;
//     default:
//         break;
// }




//   if(isset($_POST['submit'])) {
//     $username = $_POST['username'];
//     $password = $_POST['password'];
//     $conexao = mysqli_connect("localhost","u845380189_eniac","eniac2016","u845380189_sint");
//     if(mysqli_connect_errno()) {
//       exit("Não foi possível se conectar ao banco de dados");
//     }

//     $table = "`u845380189_sint`.`usuario`";
//     $query = "SELECT  * FROM  $table WHERE ({$table}.usuNome = '{$username}') AND ({$table}.usuSenha = '{$password}')";
//     mysqli_query($conexao,$query);
//     $result = mysqli_affected_rows($conexao);
//     if($result < 1){
//         echo "<div class='alert alert-danger'>Usuário ou Senha incorreto(s)</div>";
//     }else {
//       session_start();
//       $_SESSION['aut'] = true;
//       echo "Login realizado com sucesso..."; 
//       header("refresh:2; url=index.php");        
//     }
//  }

?>