<?php 
session_start();
$messageToAll = 'The manager didnt update yet any messages...';
ob_start();

?>
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
require_once('Templates/adminsNav.php'); 
?>

<?php require_once("Templates/adminsTable.php") ?>
<?php require_once("languages/languages.php") ?>
<?php 




$logged = new Admin('', '', '');
$url = new Query_check();
$submitions = new Submitions('','','','');
($logged->checkIfLoggedIn()) ? true:$url->exitApp();

$dataBase = new DataBaseCommands('','','');
$getInfo = new AdminInfo('','');


?>
<div id='adminAlerts'>
    <h2 >Worker Status</h2>
    <div id='submited'>
    <h5>Submited</h5>
    <ul>
<?php

    $dataBase->printSubmitedUsers();

?>
</ul>
    </div>
    <div id='notsubmited'>
    <h5>Didn't Submit</h5>
    <ul>
    <?php
    $dataBase->printNotSubmitedUsers();
    ?>
    </ul>
    </div>
    <form action="" method='POST'>
        <button name='resetSubs' class='btn-danger'>Reset Submitions</button>
        <?php if(isset($_POST['resetSubs']))
                $submitions->deleteAllSubs();
        ?>
    </form>
</div>

<div id='setDayTypeAndMinimum'>
    <form method="GET">
        <div class="row">
            <div class="col-md-12">
                <h5>Set Required shift's Of Work</h5>
            </div>
                <div class="col-md-12">
                    <label for="dayType">Set required shift</label>
                    <select name="dayType" id="selection">
                        <!-- returns all shifts as <option> tags -->
                        <?php $getInfo->getAllShifts(); ?>
                    </select>
                </div>
            <div class="col-md-12">
                <label for="minimumSelect">Set mininum of required shift to select</label>
                <select name="minimumSelect" id="selection">
                <?php for ($i=1; $i <= 7; $i++) { 
                    echo "<option value=\"$i\">$i</option>";
                }
                ?>

            </select>
            </div>
            <button name='sendWorkRequ' class='btn-primary'>Set</button>
            <div class="col-md-12">
            <?php 
                if(isset($_GET['sendWorkRequ'])){
                    $minimumDays = $_GET['minimumSelect'];
                    $dayType = $_GET['dayType'];
                    $setRequirements = new AdminInfo($minimumDays,$dayType);
                    $setRequirements->setDayType();
                    

                }
            ?>
            
                <h5>Current</h5>
                <p>Shift: <?php echo $getInfo->getDayType(); ?></p>
                <p>Minimum: <?php echo $getInfo->getDayMinimum(); ?></p>

            </div>
        </div>
    </form>

</div>
<div id='closeUpdatingWrapper' class="row">
<form action="" method='POST'>
<h1>Submition Settings</h1>
<?php if($submitions->getSubmitionState()){
    
    echo "<p>Submitions are open, Workers are able to update changes at any moment.</p>";
    echo " <button name='closeSub' class='btn-danger'>Close</button>";
    if(isset($_POST['closeSub']))
    $submitions->closeSubmition();
    
}else{
        echo "<p>Submitions are closed, Workers are not able to update any changes.</p>";
    echo "<button name='openSub' class='btn-success'>Open</button>";
    if(isset($_POST['openSub']))
    $submitions->openSubmition();
}

?>
</form>
</div>


<div id="sendmessage">
<div class="row">
    <form action="adminsPanel.php" method='POST'>
<div class="col-md">
    <h2>Submit Important</h2>
</div>
<div class="col-md-12">
    <h5>Important Message</h5>
</div>
<div class="col-md-12">
    <textarea name="importantM" id="importantM" cols="30" rows="5" placeholder='Write somthing about the next week.'></textarea>
</div>
<div class="col-md-6">
    <button class='btn-success' name='sendImportant'>Send To All</button>
</div>
</form>
<div class="col-md-12">
    <h5>Current Message</h5>
</div>
<?php 

if(isset($_POST['sendImportant'])){
    
    $message = $_POST['importantM'];
    $adminsImportantMessage = new AdminsMessage($message);
    $adminsImportantMessage->setAdminsMessage();
    $getInfo->setWorkDays('1,1,1,1,1,0,0');
}
?>
<div class="col-md-12">
    
    <p>
        
    <?php 

        $adminsImportantMessage = new AdminsMessage('');
        echo $adminsImportantMessage->getAdminsMessage();
    
    ?>
    
    </p>

</div>

</div>
</div>

<?php 
echo "<script src=\"javaScript_files/adminsPanel.js\"></script>";
require_once("Templates/mainHTMLFooter.html"); ?>
