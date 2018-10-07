<?php 

class NewShifts extends DataBaseCommands{


        protected $shift;
        protected $daysOfWork;
        protected $shiftType;

        public function __construct($shift, $daysOfWork) {
            $this->shift = $shift;
            $this->daysOfWork = $daysOfWork;
        }
    

        public function getShiftTypeLastIndex(){
        
            $temp = DataBaseCommands::getShiftTypeIndex();
            $temp = (int)$temp;
            return $temp += 1;
            
        }
    
    
        public function buildShift(){            
            $shiftType = $this->getShiftTypeLastIndex();
            $result ="
            <option value=\"$shiftType\">
            $this->shift
            </option>
            ";
            $this->shiftType++;
            $this->uploadNewShift($this->shift, $shiftType, $this->daysOfWork);
            return $result;

        }

        


        

        public function printSelectionTable($day0, $day1, $day2, $day3, $day4, $day5, $day6){
            $weekDays = 7;
            echo "<tr>";
            for ($i=0; $i < $weekDays; $i++) { 
                echo "
                    <td>
                    <select class='sellectPre form-control selcls' name=\"selectPre[]\" id=\"\">
                    "; 
                        foreach (${"day$i"} as $key => $value) {
                            echo "
                                $value
                            ";
                        }
                echo"
                    </select>
                    </td>
                ";
            }
            echo "</tr>";
        }

        public function getSavedShifts(){

            $resultsArr = [];
            $query = "SELECT `shift_name`, `shift_type`, `days_of_work` FROM `shifts` ORDER BY `shift_type`;";
            $result = $this->dbConnect()->query($query);
            while ($res = $result->fetch_assoc()) {
                    $resultsArr[] = $res;
            } 

            return $resultsArr;
        
    }

}


class UpdateShifts extends NewShifts {



}







class Shifts extends NewShifts {

    protected $shift;
    protected $daysOfWork;

    public function __construct($shift, $daysOfWork) {
        $this->shift = $shift;
        $this->daysOfWork = $daysOfWork;
    }


    public function getSelectBar(){
        $result = $this->getOptions();

            echo"
            <tr>
            <td></td>
            <td>Add Workers</td>";
        for ($i=0; $i < $this->daysOfWork; $i++) { 
            echo "
            <td>
            <select name=\"$this->shift$i\">
            $result
            </select>
            <button name=\"add$i\">Add</button>
            </td>";
        }
        echo "</tr>";

        $this->addWorker();
                
        
        
    }
    public function buildAllShiftsTrRows(){
        $result = '';
        $weekDays = 7;
        $day0 = [];
        $day1 = [];
        $day2 = [];
        $day3 = [];
        $day4 = [];
        $day5 = [];
        $day6 = [];
        $savedShifts = $this->getSavedShifts();
        for ($i=0; $i < count($savedShifts); $i++) { 
            $daysOfWork = $savedShifts[$i]['days_of_work'];
            $daysOfWork = preg_split("/,/", $daysOfWork);
            for ($j=0; $j < $weekDays; $j++) { 
                
                if($daysOfWork[$j] === '1'){
                    
                    ${"day$j"}[] = "
                    <option value=\"" . $savedShifts[$i]['shift_type'] . "\">
                    " . $savedShifts[$i]['shift_name'] . "
                    </option>
                    ";
                    
                }elseif($daysOfWork[$j] === '0'){
                    ${"day$j"}[] = "
                    <option value=\"0\">
                    ----
                    </option>
                    ";
                }

            }
        }
        $this->printSelectionTable($day0, $day1, $day2, $day3, $day4, $day5, $day6);
        

    }

    function deleteShift(){
        $delete = $_GET['delete'];
        foreach ($delete as $key => $value) {
            $query = "DELETE FROM `shifts` WHERE shift_name = \"$key\";";
            $this->dbConnect()->query($query);
        }
        
    }

    public function getOptions(){
    
        $allUsers = DataBaseCommands::getAllUsers();
        $result = '';
        foreach ($allUsers as $key => $value) {
            
            $result .=  "<option value=\"$value[1]\">$value[0]</option>";
        }
        return $result;
    }

    public function addWorker(){
            for ($i=0; $i < $this->daysOfWork; $i++) { 
                if(isset($_GET["add$i"])){
                    var_dump($this->shift);
                        $selectedWorker = $_GET["$this->shift$i"];
                        $this->goAndAdd($selectedWorker, $i, $this->shift); 
                        break;
            }
        }
    }

    public function goAndAdd($selectedWorker, $day, $shift){

        $query = "SELECT  `Submition` FROM `submitions` WHERE `Email` = '$selectedWorker';";
        $selectSub = $this->dbConnect()->query($query);
        $selectSub = $selectSub->fetch_assoc();
        $selectSub = preg_split("/,/", $selectSub['Submition']); 
        $selectSub[$day] = $shift;
        $selectSub = implode(",", $selectSub);
        $updateQuery = "UPDATE `submitions` SET `Submition`='$selectSub' WHERE `Email` = '$selectedWorker';";
        $this->dbConnect()->query($updateQuery);
        
    }
}

class Submitions extends Shifts {

    protected $submition;
    protected $email;
    protected $userName;
    static $freeDay = [];
    static $morning = [];
    static $eavning = [];
    static $both = [];


    public function __construct($submition, $email, $userName){

        $this->submition = $submition;
        $this->email = $email;
        $this->userName = $userName;

    }

    


    
    public function getCurrentDayWorkers($num,$day){
        $workers = $this->getUserSubmition();
        for ($i=0; $i < count($workers); $i++) { 
            $tempSub = $workers[$i]['Submition'];
            $tempSub = explode(",", $tempSub);
            for ($j=$day; $j <= $day; $j++) { 
                
                if($tempSub[$j] === $num){
                    $this->printWorker($workers[$i]['worker_name'], $tempSub[$j], $day); 
                    break;
                }
                
            }
            
        }
        
        
    }
    
    public function printWorker($worker, $workerSub, $day){
        if($workerSub){
            $this->uploadToWorkersSubs($workerSub, $worker, $day);
            echo "
            <h6><span style='color:red;'>Delete</span><input name='selectedWorkersMorning" . $day ."[]' type=\"checkbox\" value='$worker' title=\"Check to delete worker from the list\"> $worker</h6>
            ";
        }

    }

    public function uploadToWorkersSubs($workerSub, $worker, $day){
        
        if($day === '0'){
            $query = "INSERT INTO `workers_subs`( `sun`) VALUES ('$worker')";
            $this->dbConnect()->query($query);
        }
        if($day === '1'){
            $query = "INSERT INTO `workers_subs`( `mon`) VALUES ('$worker')";
            $this->dbConnect()->query($query);
        }
        if($day === '2'){
            $query = "INSERT INTO `workers_subs`( `tue`) VALUES ('$worker') WHERE id = 2";
            $this->dbConnect()->query($query);
        }
        
    }
    

    public function deleteSelectedWorkers(){
        $morning = 1;
        $eavning = 2;
        $both = 3;
        for ($i=0; $i < 7; $i++) { 
            if(isset($_GET["selectedWorkersMorning$i"])){
                ${'selected' . $i} = $_GET["selectedWorkersMorning$i"]; 
                $this->goAndDelete($_GET["selectedWorkersMorning$i"], $i, $morning);
            }
        }
        for ($i=0; $i < 7; $i++) { 
            if(isset($_GET["selectedWorkersEavning$i"])){
                ${'selected' . $i} = $_GET["selectedWorkersEavning$i"]; 
                $this->goAndDelete($_GET["selectedWorkersEavning$i"], $i, $eavning);
            }
        }
        for ($i=0; $i < 7; $i++) { 
            if(isset($_GET["selectedWorkersBoth$i"])){
                ${'selected' . $i} = $_GET["selectedWorkersBoth$i"]; 
                $this->goAndDelete($_GET["selectedWorkersBoth$i"], $i, $both);
            }
        }

    }

    public function goAndDelete($selectedWorkers, $day, $shift){

            for ($i=0; $i < count($selectedWorkers); $i++) { 
                $query = "SELECT  `Submition` FROM `submitions` WHERE `worker_name` = '$selectedWorkers[$i]';";
                $selectSub = $this->dbConnect()->query($query);
                $selectSub = $selectSub->fetch_assoc();
                $selectSub = preg_split("/,/", $selectSub['Submition']); 
                $selectSub[$day] = 0;
                $selectSub = implode(",", $selectSub);
                $updateQuery = "UPDATE `submitions` SET `Submition`='$selectSub' WHERE `worker_name` = '$selectedWorkers[$i]';";
                $this->dbConnect()->query($updateQuery);
            }
    }


    public function addSelectedWorkers(){
        $morning = 1;
        $eavning = 2;
        $both = 3;
        for ($i=0; $i < 7; $i++) { 
            if(isset($_GET["addM$i"])){
                $selected = $_GET["addWorkerMorning$i"];
                $this->goAndAdd($selected, $i, $morning); 
                break;
            }
        }
        for ($i=0; $i < 7; $i++) { 
            if(isset($_GET["addE$i"])){
                $selected = $_GET["addWorkerEavning$i"];
                $this->goAndAdd($selected, $i, $eavning); 
                break;
            }
        }
        for ($i=0; $i < 7; $i++) { 
            if(isset($_GET["addB$i"])){
                $selected = $_GET["addWorkerBoth$i"];
                $this->goAndAdd($selected, $i, $both); 
                break;
            }
        }
        

    }


    public function goAndAdd($selectedWorkers, $day, $shift){
    
            $query = "SELECT  `Submition` FROM `submitions` WHERE `Email` = '$selectedWorkers';";
            $selectSub = $this->dbConnect()->query($query);
            $selectSub = $selectSub->fetch_assoc();
            $selectSub = preg_split("/,/", $selectSub['Submition']); 
            $selectSub[$day] = $shift;
            $selectSub = implode(",", $selectSub);
            $updateQuery = "UPDATE `submitions` SET `Submition`='$selectSub' WHERE `Email` = '$selectedWorkers';";
            $this->dbConnect()->query($updateQuery);
            
    }



    public function deleteAllSubs(){
    
        $query = "DELETE FROM `submitions`";
        $this->dbConnect()->query($query);
        $this->updateUserSubStatus();
    }

    public function updateUserSubStatus(){

        $query = "UPDATE `users` SET `submited`= 'false'";
        $this->dbConnect()->query($query);
        $this->refreshPage();
        

    }

    
    public function refreshPage(){
        
        $url = $_SERVER['PHP_SELF'];
        header("Refresh:0");
        
        
    }



    public function getUserSubmition(){

            $array = [];
            $query = "SELECT `Submition`, `worker_name`  FROM `submitions`";
            $res = $this->dbConnect()->query($query);
            while ($result = $res->fetch_assoc()) {

                $array[] = $result;

            }
            
            return $array;
            
    }


    function createTable(){
        $allSubs = $this->getUserSubmition();
        for ($i=0; $i < count($allSubs); $i++) { 
            $this->addWorkerInOrder($allSubs[0]['worker_name'],$allSubs[0]['Submition']);
        }
        //print object
    }

    function addWorkerInOrder($worker, $sub){
        $this->buildAllShiftsTrRows();
    }

public function closeSubmition(){

    $query = "UPDATE `on_off_submition` SET `on_off`='off' WHERE `id` = 1";
    $this->dbConnect()->query($query);
    $this->refreshPage();
    
}
public function openSubmition(){

    $query = "UPDATE `on_off_submition` SET `on_off`='on' WHERE `id` = 1";
    $this->dbConnect()->query($query);
    $this->refreshPage();
    
}

public function getSubmitionState(){

    $query = "SELECT  `on_off` FROM `on_off_submition` WHERE `id` = 1";
    $result = $this->dbConnect()->query($query);
    $result = $result->fetch_assoc();
    if($result['on_off'] == 'off'){

        return false;

    }else{

        return true;

        }
    
    }

}

?>