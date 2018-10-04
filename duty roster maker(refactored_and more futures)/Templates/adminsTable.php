<?php require_once('methods_classes/DB_classes/DB_classes.php'); 
$dataBase = new DataBaseCommands('','','');

#region ---- On Progress...

$shifts = new Shifts('both', 7);
$newShift = new NewShifts("Example", "1,1,1,1,1,0,0");
$newShift->buildShift();

#endregion ---- On Progress...
?> 





<div id="adminsTableWraper" class='container'>



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
    
    
        <!-- <form action="" method='GET'> -->
        <?php 
        // $shifts = new Shifts(1, 7); //this is for getting the sellect bar for the newShift
        // echo $shifts->getSelectBar();
        ?>
        <!-- </form> -->
        
<?php
        
?>

    

    <?php for ($i=0; $i < 7; $i++) { 
        # code...
        $submitions = new Submitions('','','','');
        
    } ?>
    

    

    <?php

    $allShifts = $newShift->getSavedShifts(); 
    
    for ($j=0; $j < count($allShifts); $j++) { 
        $shiftName = $allShifts[$j]['shift_name'];
        $shiftType = $allShifts[$j]['shift_type'];
    ?>
    <tr>
        <td class='p-0'><i class="fas fa-minus-circle fa-plus-circle"></i></td>
        <td><?php echo $shiftName  ?><!-- here needs to be the shifts name --></td>
        
        <?php for ($i=0; $i < 7; $i++) { //runs and checks if user sub is match to the shift type
        ?> 
        <td>
            <?php

            $submitions->getCurrentDayWorkers($shiftType,"$i");

            if(isset($_GET['deleteSelected'])){   //this is getting all the admins sellections fot deleting and deletes them
                $submitions->deleteSelectedWorkers();
            }
            
            ?>   
        </td>
        <?php
        }
        ?>
    </tr>

<?php } ?>
<tr>
    <td id='addShiftTd' class='p-0'>
        <button type='button' data-target='#newShiftEditor' data-toggle='collapse'><i class="fas fa-plus-circle"></i></button>
    </td>
</tr>
</tbody>

</table>
    <div id='newShiftEditor' class="collapse">
        <div class="container border p-3" style='color:white'>
        <form action="" method='POST'>
            <table class='row'>
                <thead>
                    <tr>
                        <td>Shift Name</td>
                        <td>Sun</td>
                        <td>Mon</td>
                        <td>Tus</td>
                        <td>Wed</td>
                        <td>Thu</td>
                        <td>Fri</td>
                        <td>sat</td>
                    </tr>
                </thead>
                <tbody>
                <tr>
                    <td><input class='w-100 rounded' type="text"></td>
                    
                    <?php
                    for ($i=0; $i < 7; $i++) { 
                    ?>
                    <td>
                        <select class='p-1' name="onOffDay">
                        <option value="1">On</option>
                        <option value="0">Off</option>
                        </select>
                    </td>
                    
                    <?php } ?>
                    
                </tr>
                <tr>
                    <?php
                            for ($i=0; $i < 7; $i++) { ?>
                            <td></td><?php } ?>
                            <td> <button name='addNewShift' id='AddNewShiftB' class='rounded px-4 py-1 m-2  btn-success'>Add</button></td>
                            </tr>
                
            </tbody>
            
        </table>
        </form>
    </div>
    </div>
                <?php 
                    if(isset($_POST['addNewShift'])){
                        echo "<h1 style='color:red;'>Hi There Ariel nykänen Look At Your Goal Note If This Succeed's</h1>";
                    }
                ?>

<button name='deleteSelected' class='btn-danger'>Delete Selected</button>
<button name='submitOrder' class='btn-primary'>Submit Order</button>

</form>



</div>
