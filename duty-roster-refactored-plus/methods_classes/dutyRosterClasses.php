<?php 

class ValidateContent {

    public function notEmpty(){
        
        
        $dataArray = func_get_args();
        for ($i=0; $i < count($dataArray); $i++) { 
            if(empty($dataArray[$i]))
            return true;
        }
        return false;
    }

    public function notExistEmail($email){

        $connection = get_connection();
        $queryCheck = "SELECT * FROM `users` WHERE Email='$email'";
        $result = mysqli_query($connection, $queryCheck);
        if(mysqli_num_rows($result) > 0){
            
            return true;
            
        }else{
    
            return false;
    
        }

    }
}

class CreateUser{

    private $fullName;
    private $email;
    private $phoneNum;
    private $password;

    function __get($user){

        return $this->$user;
        
    }



    public function __construct($fullName, $email, $phoneNum, $password){

        $this->fullName = $fullName;
        $this->email = $email;
        $this->phoneNum = $phoneNum;
        $this->password = $password;
    
    }



}




?>