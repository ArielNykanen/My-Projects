<?php 
    require_once('methods_classes/Register_methods/Reg_methods.php');
#region ----get dbConnection to DB 

function DB_get_connection(){

    return mysqli_connect("localhost", "root", "1212", "registeredusersdr");

}

function DB_get_submitionTB(){

    return `submitions`;

}

function DB_check_if_submited($Email){

    $connection = DB_get_connection();
    $submitionTable = DB_get_submitionTB();
    $Email = $_SESSION['fullName'];
    $queryCheck = "SELECT * FROM `submitions` WHERE Email='$Email'";
    $result = mysqli_query($connection, $queryCheck);
    
    if(isset($_GET['submitD']) && mysqli_num_rows($result) > 0){

        return true;

    }else{

        return false;

    }

}

function DB_get_admins_message(){

    $connection = DB_get_connection();
    $getMessage = "SELECT mesage FROM admins";
    $results = mysqli_query($connection, $getMessage);
    $message = mysqli_fetch_array($results);
    if(!empty($message[0])){
        return $message[0];
        
    }else{

        return false;

    }

}

#endregion ----get dbConnection

#region ----get admins minimum work days type 

function DB_get_minimum_work_type(){
    
    $connection = DB_get_connection();
   
}

#endregion ----get admins minimum work days type   

#region ----get admins minimum required work days 
function DB_get_minimum_work_days(){

    $connection = DB_get_connection();
    $query = "SELECT * FROM minimumwork WHERE minimumDay;";
    $result = mysqli_query($connection, $query);
    if(mysqli_num_rows($result) === 1)
        return $result;
        else return false;

}
#endregion ----get admins minimum required work days

#region ----check if user exists in db 

function DB_check_if_user_exist($usersPass, $usersEmail){

    $connection = DB_get_connection();
    $usersPass = md5($usersPass);
    $query = "SELECT * FROM `users` WHERE Email='$usersEmail' AND password='$usersPass'";
    $result = mysqli_query($connection, $query);
    if(mysqli_num_rows($result) === 1)
        return true;
        else return false;

}

#endregion ----check if user exists in db

#region ----sending user to db 

function DB_send_user_to_db($user){
    var_dump($user);
    $connection = DB_get_connection();
    $query = "INSERT INTO users(FullName, Email, phoneNum, password) VALUES(
    '$user->fullName', '$user->email', '$user->phoneNum', '$user->password')";

    if(mysqli_query($connection, $query)){

        return true;

    }else{

        return false;

    }

}

#endregion ----sending user to db

#region ----preparing any string befor uploading to db 

function DB_real_escape($string){

    $connection = DB_get_connection();
    return mysqli_real_escape_string($connection, $string);

}

#endregion ----preparing any string befor uploading to db

#region ----checking dataBase if Email exsists
function DB_email_existing_check($email){
    $connection = DB_get_connection();
    $queryCheck = "SELECT * FROM `users` WHERE Email='$email'";
    $result = mysqli_query($connection, $queryCheck);
    if(mysqli_num_rows($result) > 0){
        
        return true;
        
    }else{

        return false;

    }

}

#endregion ----checking dataBase if Email exsists

?>