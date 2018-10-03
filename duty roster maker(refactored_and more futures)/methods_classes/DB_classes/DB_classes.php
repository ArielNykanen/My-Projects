<?php
require_once("methods_classes/workers_panel/workers_classes.php");

class DbConnect {
    private $host;
    private $name;
    private $pass;
    private $dataBase;

    

    
    public function dbConnect(){

        $this->host = "127.0.0.1";
        $this->name = "root";
        $this->pass = "1212";
        $this->dataBase = "registeredUsersdr";

        $connect = new mysqli($this->host, $this->name, $this->pass, $this->dataBase);
        return $connect;

    }

}



class DataBaseCommands extends dbConnect {
    protected $email;
    protected $file;
    protected $userName;

    public function __construct($email, $file, $userName){

    
        $this->email = $email;
        $this->file = $file;
        $this->userName = $userName;

    }

    public function getConn(){

        var_dump($this->dbConnect());
    
    }
    


    public function prepareFile(){
    
        if(is_array($this->file))
        return  $this->file = implode(",",$this->file);
        else
        return $this->file;

    }


    public function realEscape(){

        $this->email = mysqli_real_escape_string($this->dbConnect(), $this->email);
        $this->file = mysqli_real_escape_string($this->dbConnect(), $this->file);
        $this->userName = mysqli_real_escape_string($this->dbConnect(), $this->userName);

    }

    public function getShiftTypeIndex(){
    
        $query = "SELECT shift_type FROM shifts ORDER BY shift_type DESC LIMIT 1;";
        $result = $this->dbConnect()->query($query);
        $result = $result->fetch_assoc();
        return $result['shift_type'];

    }

    public function uploadNewShift($shift, $shiftType, $daysOfWork){

        $query = "INSERT INTO `shifts`(`shift_name`, `shift_type`, `days_of_work`) VALUES (\"$shift\",\"$shiftType\",\"$daysOfWork\")";
        $this->dbConnect()->query($query);
        
    }

    

    

    public function deleteShift(){
    
        
        
    }

    public function getUserName(){

        $query = "SELECT  `FullName`  FROM `users` WHERE Email = '$this->email'";
        $result = $this->dbConnect()->query($query);
        $user = $result->fetch_array();
        $this->userName = $user['FullName'];
        
    }


    public function execute(){

        $this->getUserName();
        $this->prepareFile();
        $this->realEscape();
        if($this->checkRequireMents()){

            if($this->checkIfSubmited()){
                $query = "INSERT INTO submitions(worker_name,Email,submition) VALUES('$this->userName','$this->email' ,'$this->file');";
                $this->upload($query);
                    return;
            }else{
                $this->updateUploaded();
            }

        }else{
            return false;
        }
        
    }

    public function checkRequireMents(){
    
        $query = "SELECT `minimumDay`, `daytype` FROM `minimumwork`";
        $result = $this->dbConnect()->query($query);
        $result = $result->fetch_assoc();
        $requiredShift = $result['daytype'];
        $minimumOfselections = $result['minimumDay'];
        #returning true or false 
        return $this->checkIfMinimumReached($requiredShift, $minimumOfselections);
    
    }

    public function checkIfMinimumReached($shift, $minimumSelect){
        $counter = 0;
        $workerSelections = $this->file;
        $workerSelections = preg_split("/,/", $workerSelections);
        for ($i=0; $i < count($workerSelections); $i++) { 
            if($workerSelections[$i] === $shift){
                
                $counter++;

            }
            if ($counter == $minimumSelect) {
                return true;
            }
        }
        #if condition is not true whole the loop the return false
        return false;
    }


    public function checkIfSubmited(){

        $query = "SELECT  `Email`, `Submition` FROM `submitions` WHERE Email = \"$this->email\"";
        $result = $this->dbConnect()->query($query);
        $result = $result->fetch_array();

        if(is_array($result)){

            return false;

        }
        return true;

    }


    public function upload($query){

        // echo "<h1 style='color:red;'>$this->email</h1>";
        $this->dbConnect()->query($query);
        $query = "UPDATE `users` SET `submited`= 'true' WHERE `Email` = \"$this->email\"";
        $this->dbConnect()->query($query);
        
    }



        public function updateUploaded(){
            
            $query = "UPDATE `submitions` SET `Submition`= '$this->file'  WHERE `Email`  =  \"$this->email\"";
            $result = $this->dbConnect()->query($query);
            
        }



        public function getAllUsers(){

            $query = "SELECT `FullName`,`Email` FROM `users`";
            $result = $this->dbConnect()->query($query);
            $result = $result->fetch_all(); 
            return $result;

        }
        
        public function getSubmitedUsers(){
            
            $query = "SELECT `worker_name` FROM `submitions`";
            $result = $this->dbConnect()->query($query);
            $result = $result->fetch_all();
            return $result;
            
            
        } 
        
        public function printSubmitedUsers(){
            
            $query = "SELECT `FullName`  FROM `users` WHERE submited = \"true\"";
            $result = $this->dbConnect()->query($query);
            
            while($res = $result->fetch_assoc()){

                echo "<li>" . $res['FullName'] . "</li>";

            }
            
        }

        
        
        public function printNotSubmitedUsers(){

            $query = "SELECT `FullName`  FROM `users` WHERE submited = \"false\"";
            $result = $this->dbConnect()->query($query);
            // $result = $result->fetch_assoc();
            
            while($res = $result->fetch_assoc()){

                echo "<li>" . $res['FullName'] . "</li>";

            }
            
            
        }


}


class CheckIfSubmited extends DataBaseCommands {

    public function __construct($email) {
        $this->email = $email;
    }

}


class GetCurrenUser extends DataBaseCommands {

    protected $userName;

    public function __construct($email, $userName) {
        
        $this->email = $email;
        $this->userName = "Not found";

    }

    public function execute(){

        $this->realEscape();
        $this->getUserName();
        echo $this->__toString();

    }

    

    public function __toString(){

        return "$this->userName";

    }

    public function submition(){

        $this->realEscape();
        $this->getUserName();
        $this->printUsersSub($this->checkSubmition());

    }

    public function checkSubmition(){

        $query = "SELECT  `submition`  FROM `submitions` WHERE Email = '$this->email'";
        $result = $this->dbConnect()->query($query);
        $submition = $result->fetch_array();
        return $submition['submition'];
        
    }

    public function printUsersSub($usersSub){

        if(!empty($usersSub)){

                $usersSub = preg_split('/,/', $usersSub);
                echo"
                <h4'>" . $GLOBALS['submitedTable']->__get("submitedHeader") . "</h4>
                <table>
                <thead>" .
                $GLOBALS['Thead'].
                "</thead>";
                foreach ($usersSub as $key => $value) {
                        if($value === '0' )
                        echo "<td  style='background-color:rgba(222,100,22,0.5);'>" . $GLOBALS['td']->__get("freeDay") ."</td>";
                        if($value === '1' )
                        echo "<td style='background-color:rgba(222,180,22,0.5);'>" . $GLOBALS['td']->__get("morning") ."</td>";
                        if($value === '2' )
                        echo "<td style='background-color:rgba(222,180,22,0.5);'>" . $GLOBALS['td']->__get("eavning") ."</td>";
                        if($value === '3' )
                        echo "<td style='background-color:rgba(222,180,22,0.5);'>" . $GLOBALS['td']->__get("both") ."</td>";
                    
                }

                echo "</table>";

            }
            

        }

}



?>

