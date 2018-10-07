<?php

    require_once('methods_classes/workers_panel/workers_classes.php'); 
    require_once('methods_classes/workers_panel/workers_methods.php'); 
    require_once('methods_classes/DB_methods/DB_methods.php');  


    
?>


<nav id='navBar'>
    
    <ul>
        <div class="row">
        <div class="col-md-12">
        <a id='requestB'><li>
            <?php 
            
            echo $navLang->Request; 
           

            ?>

        </li></a>
        </div>
        <div class="col-md-12">
        <a href="index.php?action=exit"> <li>
            <?php echo $navLang->LogOut ?>
        </li></a>
        </div>
        
    </div>
    </ul>
    
</nav>