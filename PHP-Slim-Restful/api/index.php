<?php
require 'config.php';
require 'Slim/Slim.php';

\Slim\Slim::registerAutoloader();
$app = new \Slim\Slim();

$app->post('/login','login'); /* User login */


$app->post('/register_by_idcard','register_by_idcard'); /* User login */
// $app->post('/signup','signup'); /* User Signup  */
// $app->get('/getFeed','getFeed'); /* User Feeds  */
// $app->post('/feed','feed'); /* User Feeds  */
// $app->post('/feedUpdate','feedUpdate'); /* User Feeds  */
// $app->post('/feedDelete','feedDelete'); /* User Feeds  */
// $app->post('/getImages', 'getImages');


$app->run();

/************************* USER LOGIN *************************************/
/* ### User login ### */
function login() {
    
    $request = \Slim\Slim::getInstance()->request();
    $data = json_decode($request->getBody());
    
    try {
        
        //$db = getDB();
        $db = getDBtest();
        $userData ='';
        // $sql = "SELECT user_id, name, email, username FROM users WHERE (username=:username or email=:username) and password=:password ";
        // $stmt = $db->prepare($sql);
        // $stmt->bindParam("username", $data->username, PDO::PARAM_STR);
        // $password=hash('sha256',$data->password); //syntext  ตัวเเปลงให้เป็น token 
        // $stmt->bindParam("password", $password, PDO::PARAM_STR);
        // $stmt->execute();
        // $mainCount=$stmt->rowCount();
        // $userData = $stmt->fetch(PDO::FETCH_OBJ);
        
       //เปลง code ให้เป็น json
        // $db = null;
        //  if($userData){
        //        $userData = json_encode($userData);
        //         echo '{"userData": ' .$userData . '}';
        //     } else {
        //        echo '{"error":{"text":"Bad request wrong username and password"}}';
        //     }
        //$db = null;
         if($db){
               $userData = json_encode($db);
                echo '{"userData": ' .$userData . '}';
            } else {
               echo '{"error":{"text":"Bad request wrong username and password"}}';
            }


           
    }
    catch(PDOException $e) {
        echo '{"error":{"text":'. $e->getMessage() .'}}';
    }
}






function register_by_idcard() {
    
    $request = \Slim\Slim::getInstance()->request();
    $data = json_decode($request->getBody());
    
    try {
        
        //$db = getDB();
        $db = getDB();
        // $userData ='';
        // $sql = "SELECT * FROM mem_h_member WHERE (id_card=:id_card) ";
        // $stmt = $db->prepare($sql);
        // $stmt->bindParam("id_card", $data->id_card, PDO::PARAM_STR);
        // //$password=hash('sha256',$data->password); //syntext  ตัวเเปลงให้เป็น token 
        // //$stmt->bindParam("password", $password, PDO::PARAM_STR);
        // $stmt->execute();
        // $mainCount=$stmt->rowCount();
        // $userData = $stmt->fetch(PDO::FETCH_OBJ);

        //$objConnect = oci_connect("myuser","mypassword","TCDB");
        $strSQL = "SELECT * FROM mem_h_member WHERE (id_card=:id_card) and (status_id ='01' or status_id ='04')";
        $objParse = oci_parse($db, $strSQL);
        oci_bind_by_name($objParse, ':id_card', $data->id_card);
        oci_execute ($objParse,OCI_DEFAULT);
        $objResult = oci_fetch_array($objParse,OCI_BOTH);
        
      // เปลง code ให้เป็น json
       // $db = null;
       $tmp = "okkkkkkkkkkkkk";
         if($objResult){
               $objResult = json_encode($objResult);
                //echo '{"Hellooooo": ' .$userData . '}';
                echo '{"Hellooooo": ' .$objResult. '}';
            } else {
               echo '{"error":{"text":"Bad request wrong username and password"}}';
            }
      


           
    }
    catch(PDOException $e) {
        echo '{"error":{"text":'. $e->getMessage() .'}}';
    }
}



/* ### User registration ### */
// function signup() {
//     $request = \Slim\Slim::getInstance()->request();
//     $data = json_decode($request->getBody());
//     $email=$data->email;
//     $name=$data->name;
//     $username=$data->username;
//     $password=$data->password;
    
//     try {
        
//         $username_check = preg_match('~^[A-Za-z0-9_]{3,20}$~i', $username);
//         $email_check = preg_match('~^[a-zA-Z0-9._-]+@[a-zA-Z0-9._-]+\.([a-zA-Z]{2,4})$~i', $email);
//         $password_check = preg_match('~^[A-Za-z0-9!@#$%^&*()_]{6,20}$~i', $password);
        
//         echo $email_check.'<br/>'.$email;
        
//         if (strlen(trim($username))>0 && strlen(trim($password))>0 && strlen(trim($email))>0 && $email_check>0 && $username_check>0 && $password_check>0)
//         {
//             echo 'here';
//             $db = getDB();
//             $userData = '';
//             $sql = "SELECT user_id FROM users WHERE username=:username or email=:email";
//             $stmt = $db->prepare($sql);
//             $stmt->bindParam("username", $username,PDO::PARAM_STR);
//             $stmt->bindParam("email", $email,PDO::PARAM_STR);
//             $stmt->execute();
//             $mainCount=$stmt->rowCount();
//             $created=time();
//             if($mainCount==0)
//             {
                
//                 /*Inserting user values*/
//                 $sql1="INSERT INTO users(username,password,email,name)VALUES(:username,:password,:email,:name)";
//                 $stmt1 = $db->prepare($sql1);
//                 $stmt1->bindParam("username", $username,PDO::PARAM_STR);
//                 $password=hash('sha256',$data->password);
//                 $stmt1->bindParam("password", $password,PDO::PARAM_STR);
//                 $stmt1->bindParam("email", $email,PDO::PARAM_STR);
//                 $stmt1->bindParam("name", $name,PDO::PARAM_STR);
//                 $stmt1->execute();
                
//                 $userData=internalUserDetails($email);
                
//             }
            
//             $db = null;
         

//             if($userData){
//                $userData = json_encode($userData);
//                 echo '{"userData": ' .$userData . '}';
//             } else {
//                echo '{"error":{"text":"Enter valid data"}}';
//             }

           
//         }
//         else{
//             echo '{"error":{"text":"Enter valid data"}}';
//         }
//     }
//     catch(PDOException $e) {
//         echo '{"error":{"text":'. $e->getMessage() .'}}';
//     }
// }




/* ### internal Username Details ### */
function internalUserDetails($input) {
    
    try {
        $db = getDB();
        $sql = "SELECT user_id, name, email, username FROM users WHERE username=:input or email=:input";
        $stmt = $db->prepare($sql);
        $stmt->bindParam("input", $input,PDO::PARAM_STR);
        $stmt->execute();
        $usernameDetails = $stmt->fetch(PDO::FETCH_OBJ);
        $usernameDetails->token = apiToken($usernameDetails->user_id);
        $db = null;
        return $usernameDetails;
        
    } catch(PDOException $e) {
        echo '{"error":{"text":'. $e->getMessage() .'}}';
    }
    
}


?>
