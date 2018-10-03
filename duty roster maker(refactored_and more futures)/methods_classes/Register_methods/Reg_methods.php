<?php

    require_once('methods_classes/DB_methods/DB_methods.php');


#region ----display error 

function display_error($message){

    return "<div  id='error' class=\"alert alert-danger\" role=\"alert\">
    $message
    </div>";

}

#endregion ----display error

#region ----Register validation

function go_validate_user_input($fullName, $userEmail, $userPhone, $userPass, $passAgain){

    $validationArray = [$fullName, $userEmail, $userPhone, $userPass, $passAgain];

    $errorArray = [];

    for ($i=0; $i < count($validationArray); $i++) { 

        if(empty($validationArray[$i])){

            array_push($errorArray, "Please fill all the fields");
            return $errorArray;

        }

    }

    if(strlen($userPass) < 5 && !empty($userPass)){

        array_push($errorArray, "the password is too weak make at least 5 chars long please.");

    }

    if($userPass !== $passAgain){

        array_push($errorArray, "the two passwords don't match please re enter.");

    }

    if(DB_email_existing_check($userEmail)){

        array_push($errorArray, "this email is allready registered!");

    }

    return $errorArray;

}

#endregion ----Register validation

#region ----user creation 

function create_user($fullName, $userEmail, $userPhone, $userPass, $passAgain){
    $connection = DB_get_connection();
    $fullName = DB_real_escape($fullName );
    $userEmail = DB_real_escape($userEmail);
    $userPhone = DB_real_escape($userPhone);
    $userPass = DB_real_escape($userPass);
    $userPass = md5($userPass);
    $RegisteredUser = new CreateUser($fullName, $userEmail, $userPhone, $userPass);
    if(DB_send_user_to_db($RegisteredUser)){
        return true;
    }else{
        return false;
    }

}

#endregion ----user creation
?>