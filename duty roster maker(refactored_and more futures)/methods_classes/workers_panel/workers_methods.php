<?php 
require_once("methods_classes/workers_panel/workers_classes.php");
require_once("methods_classes/DB_methods/DB_methods.php");









function get_minimum_selection(){

    $default = 3;
    $connection = DB_get_connection();
    if($result = DB_get_minimum_work_days()){
    $result = DB_get_minimum_work_days();    
    $result = mysqli_fetch_assoc($result);
    $result = $result['minimumDay'];
    return $result;
    }else
    return $default;

}


function get_minimum_type(){

    $default = 3;
    $connection = DB_get_connection();
    if($result = DB_get_minimum_work_type()){
    $result = DB_get_minimum_work_type();    
    $result = mysqli_fetch_assoc($result);
    $result = $result['daytype'];
    return $result;
    }else
    return $default;

}


function getDayType($workSelect, $number2){

    $type = $GLOBALS['td'];
    
    if($workSelect === '1'){
        return $number2 > 1 ? $type->morning . $type->daysAsMany:"$type->morning";
    }
    if($workSelect === '2'){
        return $number2 > 1 ? $type->eavning . $type->daysAsMany:"$type->eavning";
    }
    if($workSelect === '3'){
        return $number2 > 1 ? $type->both . $type->daysAsMany:"$type->both";
    }

}





function checkRequiredWork($selection, $minimumWorkType, $minimumWork){
    
    $counter = 0;
    $dayType = getDayType($minimumWorkType, $minimumWork);
    for ($i=0; $i < count($selection); $i++) { 
    
        if($selection[$i] === $minimumWorkType){
           
            $counter++;

        }
        
    }

    if($counter < $minimumWork){
                return minRequireError($minimumWork, $dayType);
            }else{
                return false;
            }


}


function checkErr($errors){
    $result = "";
    if(count($errors) > 0){
        
        foreach ($errors as $key => $value) {

            $result .= "<strong style='font-size:20px;'>$value</strong>";

        }
        
    }else{

        return;

    }

    return $result;

}


function checkSelections(){
    $errors = [];
    $selection = $_POST['sellectPre'];
    $minimumWork = get_minimum_selection();
    $minimumWorkType = get_minimum_type();
    $errors[] = checkRequiredWork($selection, $minimumWorkType, $minimumWork);
    if($errors[0] !== false){
        
            echo checkErr($errors);
            return false;

        }
        return true;

}


?>

