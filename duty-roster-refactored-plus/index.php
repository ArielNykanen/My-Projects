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
    $adminsInfo = new AdminInfo('','');
    
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
    #>>>
}

?>

<?php require_once('Templates/navBar.php'); ?> 

<div class="row">
<h4 class='smallBox' >
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
    <div class='smallCollapseBox rounded-bottom border '>    
    <button type="button" class='btn-warning m-0 px-lg-5 ' id='settingCollapser' data-target="#requirementsMenu" data-toggle="collapse">Requirements</button>
    </div>
    <div id='requirementsMenu' class='smallCollapseBox rounded-bottom border  collapse'>
    <p >
        Shift: <?php echo $adminsInfo->getDayType()?>
    </p>
    <p >
        Minimum Of Days To Select: <?php echo $adminsInfo->getDayMinimum()?>
    </p>
    </div>
    
    <table>
        
        
        <?php
        
        #region ----this needs to go to the admins panel 
        $shifts = new Shifts('both', 7);
        #endregion ----this needs to go to the admins panel

        ?>

    <tr>
        <?php echo $Thead->execute(); ?>
    </tr>
    <tr>
        <?php echo $shifts->buildAllShiftsTrRows(); ?>
    </tr>

        

        

    </table>

<fieldset id='fieldset'>

<legend><?php $extraInfo->execute(); ?> </legend>
<?php
    $adminsImportantMessage = new AdminsMessage('');
    echo $adminsImportantMessage->getAdminsMessage();
    ?>

</fieldset>
    <?php    
    

   


    if(isset($_POST['submitD'])){
        $uploadSubmition = new DataBaseCommands( $_SESSION['fullName'],  $_POST['selectPre'],"");
        if($uploadSubmition->validateSelections()){
            $submitionSuccessMessage->execute();
            
        }else{
            
            echo $minimumNotReached;
        }
        
    }




if(isset($_POST['uploadD'])){

    $uploadSubmition = new DataBaseCommands($_SESSION['fullName'],  $_POST['selectPre'],"");
    if($uploadSubmition->validateSelections()){
        $submitionSuccessMessage->execute();
    }else{
            
        echo $minimumErrNotUpdated;
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