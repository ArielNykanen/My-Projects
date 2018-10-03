<?php require_once('methods_classes/DB_classes/DB_classes.php'); 
$dataBase = new DataBaseCommands('','','');


?> 





<div id="adminsTableWraper">



<form id='submitionTable' action="" method='GET'>

<table id='adminsTable'>

    <?php echo $adminsThead;

    ?>
        <?php
        $allUsers = $dataBase->getAllUsers();
        $result = '';
        foreach ($allUsers as $key => $value) {
            
            $result .=  "<option value=\"$value[1]\">$value[0]</option>";
        }
        ?>

<tbody>
    
    
        <form action="" method='GET'>
        <?php 
        $shifts = new Shifts(1, 7);
        echo $shifts->getSelectBar();
        ?>
        </form>
<?php
        
?>

    

    <?php for ($i=0; $i < 7; $i++) { 
        # code...
        $submitions = new Submitions('','','','');
        
    } ?>
    <tr>
        <td></td>
        <?php for ($i=0; $i < 7; $i++) { 
        ?> 

        <td>

            <?php

            $submitions->getCurrentDayWorkers('1',"$i");

            if(isset($_GET['deleteSelected'])){
                $submitions->deleteSelectedWorkers();
            }
            ?>
                
        </td>

        <?php

        } 

        ?>

    
    
    </tr>
    <?php 
        $shifts = new Shifts(2, 7);
        echo $shifts->getSelectBar();
        ?>
    <tr>

        <td></td>
        <?php for ($i=0; $i < 7; $i++) { 
        ?> 

        <td>

            <?php echo $submitions->getCurrentDayWorkers('2',"$i"); ?>
            
        </td>

        <?php

        } 

        ?>
    </tr>
    <?php 
        $shifts = new Shifts(3, 7);
        echo $shifts->getSelectBar();
        ?>
    <tr>
        <td></td>        
        <?php for ($i=0; $i < 7; $i++) { 
        ?> 

        <td>

            <?php echo $submitions->getCurrentDayWorkers('3',"$i"); ?>
            
      

        <?php

        } 

        ?>
    </tr>
</tbody>

</table>

<button name='deleteSelected' class='btn-danger'>Delete Selected</button>
<button name='submitOrder' class='btn-primary'>Submit Order</button>

</form>



</div>
