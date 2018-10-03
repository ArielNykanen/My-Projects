<?php session_start(); ?>
<?php

    require_once('Templates/mainHTMLHeader.html'); 
    require_once('methods_classes/workers_panel/workers_classes.php'); 
    require_once('methods_classes/workers_panel/workers_methods.php'); 
    require_once('methods_classes/DB_methods/DB_methods.php'); 
    require_once('methods_classes/DB_classes/DB_classes.php'); 
    require_once('methods_classes/admins_panel/classes.php'); 
    require_once('methods_classes/admins_panel/addShiftsClass.php'); 

    require_once("languages/languages.php");
    $languages->getLanguage();
    
?>

<?php 
$DB_getCurrent_user = new GetCurrenUser($_SESSION['fullName'], "","");
$submitions = new Submitions('','','','');
$backGroundImage = new Js_scripts("document.body.setAttribute('style', 'background-image: url(images/MainBg.jpg);');");

echo $backGroundImage->execute(); ?>

<!--for logOut -->
<?php
$url = new Query_check();

($url->checkQueryString("action=exit")) ? $url->exitApp():false;

($url->checkIfLoggedIn()) ? true:$url->exitApp();

?>


<?php require_once("Templates/worker_request.php");




?>


<?php

if($_SERVER['QUERY_STRING'] === "action=request"){
    
}
//checking for permission to navigate to index.php

// checkIfLoggedIn();

?>

<?php require_once('Templates/navBar.php'); ?> 

<div class="row">
<h4 id='loggedInAs'>
<?php 
    echo $loggedInMessage->execute();
    echo $DB_getCurrent_user->execute();
?>
</h4>


<main>
    <h1> <?php $mainWorkerPanelHeader->execute(); ?></h1>  
        <div class="row">
<!-- getting the language sellector -->
<?php require_once("Templates/langSelector.php"); ?>

<form id='sendRef' method="POST">
    
    <table>
        
        
        <?php
        #region ----this needs to go to the admins panel 
        
        $shifts = new Shifts('both', 7);
        $newShift = new NewShifts("Example", "1,1,1,1,1,0,0");
        $newShift->buildShift();
        
        #endregion ----this needs to go to the admins panel
        ?>

    <tr>
        <?php echo $Thead->execute(); ?>
    </tr>
    <tr>
        <?php echo $shifts->buildAllShiftsTrRows(); ?>
    </tr>

        <!-- // echo $td->execute();
        // echo makeTableTdLang(2); //integer for how many td's dont forget to let the admin to chose -->

        

    </table>

<fieldset id='fieldset'>

<legend><?php $extraInfo->execute(); ?> </legend>
<?php
    $adminsImportantMessage = new AdminsMessage('');
    echo $adminsImportantMessage->getAdminsMessage();
    ?>

</fieldset>
    <?php    
    

    //I MADE THE TH TD TO BE FLEXIBALE FOR FUTURE NOW YOU NEED TO MAKE THE TABLE AND MAKE NEW OBJECTS FROM TH TD IN ANY LANGUAGE YOU WANT IN MATTER OF SECOUNDS!!!! WHOOO HOOO!!


    if(isset($_POST['submitD'])){
        $uploadSubmition = new DataBaseCommands( $_SESSION['fullName'],  $_POST['selectPre'],"");
        if($uploadSubmition->execute()){
            $submitionSuccessMessage->execute();
        }else{
            minRequireError();
        }
        
    }




if(isset($_POST['uploadD'])){

    $uploadSubmition = new DataBaseCommands($_SESSION['fullName'],  $_POST['sellectPre'],"");
    if($uploadSubmition->execute()){
        $submitionSuccessMessage->execute();
    }

}






?>

<?php

$checkIfSubmited = new DataBaseCommands($_SESSION['fullName'],  '',"");

if($checkIfSubmited->checkIfSubmited()){

    echo "<button id='submition' name='submitD' class='btn-primary'>
    $Submit->message 
    </button>";
    
}else if($submitions->getSubmitionState()){
    
    $DB_getCurrent_user->submition();
    echo "<button id='submition' name='uploadD' class='btn-success'>
    $Update->message 
    </button>";

}else{

    $DB_getCurrent_user->submition();

}

?>


</form>

</div>
</div>
</main>


<?php  ?>

<?php
require_once('Templates/mainHTMLFooter.html');
echo "<script src=\"javaScript_files/requestPanel.js\"></script>";
?>