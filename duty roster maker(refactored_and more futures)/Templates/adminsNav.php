    <?php 

    require_once('methods_classes/workers_panel/workers_classes.php'); 
    require_once('methods_classes/workers_panel/workers_methods.php'); 
    require_once('methods_classes/DB_methods/DB_methods.php');  



    ?>

<nav id='AnavBar'>
    <ul>
        <a id='userRequests' href="workerRequests.php"><li>
        <?php echo $adminsNav->WorkerRequests ?>
        </li></a>
        <a href="adminsPanel.php"> <li>
        <?php echo $adminsNav->AdminsPanel ?>
        </li></a>
        <a href="index.php?action=exit"> <li>
        <?php echo $adminsNav->LogOut ?>
        </li></a>
    </ul>

</nav>