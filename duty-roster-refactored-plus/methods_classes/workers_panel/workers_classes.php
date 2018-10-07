<?php
    require_once('methods_classes/DB_classes/DB_classes.php'); 


class Query_check {

    public function checkQueryString($string){
        
        return $_SERVER['QUERY_STRING'] === "$string";
    
    }

    public function checkIfLoggedIn(){

        if(isset($_SESSION['fullName'])){
        
            return true;
    
        }else{
            
            return false;
                
        }
    
    }

    public function exitApp(){

        session_destroy();
        header("location:  register.php?action=login");

    }
    

}


class Js_scripts {

    public $jsLine;


    public function __construct($jsLine) {
        $this->jsLine = $jsLine;
    }


    public function execute(){

        return $this->createScripts();

    }


    public function createScripts(){

        return "
        <script>
        
        $this->jsLine
        
        </script>
        ";

    }

    
    
}


class Worker extends DataBaseCommands {


    public function __construct($email, $file, $userName){

    
        $this->email = $email;
        $this->file = $file;
        $this->userName = $userName;

    }


    public function setRequest(){

        $currentDate = date("d/m");
        $this->getUserName();
        $this->realEscape();
        $query = "INSERT INTO workerrequests(workerName,requestMessage,request_date) VALUES('$this->userName' ,'$this->file', \"$currentDate\");";
        $this->dbConnect()->query($query);    
        $this->refreshPage();
    }

    public function refreshPage(){

        header("Refresh:0");
        
        

    }


    public function getRequest(){

            $this->getUserName();
            $query = "SELECT  `workername` FROM `workerrequests` WHERE workername = \"$this->userName\"";
            $result = $this->dbConnect()->query($query);
            $result = $result->fetch_array();
            if(is_array($result)){

                return true;

            }

            return false;

    }

    public function getAnswer(){
        
        $query = "SELECT `workerName`,  `answer`, `request_date` FROM `workerrequests` WHERE `workerName` =  \"$this->userName\"";
        $result = $this->dbConnect()->query($query);
        $result = $result->fetch_array();
        if($result['answer'] !== null){

            return "
            <p>" . $result['answer'] . "</p>
            ";

        }

        return false;
        
    }

    public function getQuestion(){

        $this->getUserName();
        $query = "SELECT `requestMessage` FROM `workerrequests` WHERE `workerName` = \"$this->userName\"";
        $result = $this->dbConnect()->query($query);
        $result = $result->fetch_array();
        return $result['requestMessage'];

    }

    public function deleteRequest(){

        $this->getUserName();
        $query = "DELETE FROM `workerrequests` WHERE `workerName` = \"$this->userName\"";
        $result = $this->dbConnect()->query($query);
        $this->refreshPage();
    }


    public function __destruct(){

    

    }

}

?>