<?php

class Admin extends Worker{

    public function checkIfLoggedIn(){
        
        
        if(isset($_SESSION['Admin']) && $_SESSION['Admin']  === "true"){

            return true;
            
        }else{
            
            return false;
            
        }

    }



    public function getWorkersRequests(){

        $query = "SELECT `workerName`, `requestMessage`, `request_date`, `answer` FROM `workerrequests`;";
        $result = $this->dbConnect()->query($query);
        while($workers = $result->fetch_assoc()){
            
            if($workers['answer'] != true){

            echo "
            <form action=\"\" method='GET'>
            <tr>
            <td>" . $workers['workerName'] . "</td>
            <td>" . $workers['requestMessage'] ."</td>
            <td>" . $workers['request_date'] ."</td>
            <td><textarea name=\"answer[$workers[workerName]]\" cols=\"40\" rows=\"4\"></textarea></td>
            <td><button class='btn-success' name=\"sendAnswer\"> Send </button></td>
            </tr>
            </form>

            ";
        }

        }

    }




    public function sendAnswer($worker){
        
        $answer = '';
        $workerName = '';
        
        foreach ($worker as $key => $value) {
            $workerName = $key;
            $answer = $value;
        }

        $query = "UPDATE `workerrequests` SET`answer`='$answer'  WHERE `workerName` = '$workerName';";
        $result = $this->dbConnect()->query($query);
        $this->deleteWorkerRequest($workerName);

    }

    public function deleteWorkerRequest($workerName){

        $query = "UPDATE `workerrequests` SET`answered` = 'true'  WHERE `workerName` = '$workerName';";
        $result = $this->dbConnect()->query($query);
        
    }

   


    public function exitApp(){

        session_destroy();
        header("location:  register.php?action=login");
        exit();

    }

}

class AdminInfo extends DbConnect {

    protected $minimumNeededSelection;
    protected $neededWorkDayType;


    public function __construct($minimumNeededSelection, $neededWorkDayType) {

        $this->minimumNeededSelection = $minimumNeededSelection;
        $this->neededWorkDayType = $neededWorkDayType;

    }

    public function setDayType(){

        // echo $this->minimumNeededSelection[0];
        $query = "UPDATE `minimumwork` SET `minimumDay`= $this->minimumNeededSelection ,`daytype`= $this->neededWorkDayType WHERE id = 1;";
        $result = $this->dbConnect()->query($query);
        

    }


    public function getDayType(){

        $query = "SELECT `daytype` FROM `minimumwork`;";
        $result = $this->dbConnect()->query($query);
        $result = $result->fetch_assoc();
        $result = implode($result);
        return $result;

    }


    public function getDayMinimum(){

        $query = "SELECT `minimumDay` FROM `minimumwork`;";
        $result = $this->dbConnect()->query($query);
        $result = $result->fetch_assoc();
        $result = implode($result);
        return $result;

    }


    public function setWorkDays($days){

        $query = "UPDATE `admins` SET `days_of_work`= \"$days\" ;";
        $this->dbConnect()->query($query);

    }


    public function getWorkDays(){

        # code...

    }

    

    public function __destruct(){
        
        // echo "<h5 style='color:white;'>End Of Admins Class</h1>";

    }
    
    
}

class AdminsMessage extends AdminInfo {

    private $message;

    public function __construct($message) {
        
        $this->message = $message;

    }

    public function setAdminsMessage(){

        $query = "UPDATE `admins` SET `message`= \"$this->message\";";
        $this->dbConnect()->query($query);

    }


    public function getAdminsMessage(){

        $query = "SELECT `message` FROM `admins`;";
        $result = $this->dbConnect()->query($query);
        $result = $result->fetch_assoc();
        $result = implode($result);
        return $result;

    }

}


?>