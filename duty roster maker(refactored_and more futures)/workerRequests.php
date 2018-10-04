<?php 
session_start();
?>
<?php

require_once('Templates/mainHTMLHeader.html'); 
require_once('methods_classes/workers_panel/workers_classes.php'); 
require_once('methods_classes/workers_panel/workers_methods.php'); 
require_once('methods_classes/DB_methods/DB_methods.php'); 
require_once('methods_classes/DB_classes/DB_classes.php'); 
require_once('methods_classes/admins_panel/classes.php'); 
require_once("languages/languages.php");
$languages->getLanguage();
require_once('Templates/adminsNav.php'); 
?>

<?php require_once("languages/languages.php") ?>
<?php

$admin = new Admin('','','');
$url = new Query_check();
($admin->checkIfLoggedIn()) ? true:$url->exitApp();

$dataBase = new DataBaseCommands('','','');
$getInfo = new AdminInfo('','');
?>

<h1 style='color:white;'>Worker requests</h1>

<table id='workerRequestsTable'>
<thead>
<th>Worker Name</th>
<th>Request</th>
<th>Date</th>
<th>Answer</th>
<th>Send Answer</th>
</thead>
<tbody>



<?php

$admin->getWorkersRequests();

?>

<?php
if(isset($_GET['sendAnswer'])){

    $worker = $_GET['answer'];
    $admin->sendAnswer($worker);

}
?>

</tbody>
</table>




<?php
echo "<script src=\"javaScript_files/adminsPanel.js\"></script>";
require_once("Templates/mainHTMLFooter.html"); ?>
