<?php require_once('methods_classes/DB_classes/DB_classes.php'); 
$dataBase = new DataBaseCommands('','','');

#region ---- On Progress...

$shifts = new Shifts('both', 7);


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

    $allShifts = $shifts->getSavedShifts(); 
    
    for ($j=0; $j < count($allShifts); $j++){ 
        $shiftName = $allShifts[$j]['shift_name'];
        $shiftType = $allShifts[$j]['shift_type'];
    ?>
    <?php
    // echo $shifts->getSelectBar();
    ?>
    <tr>
        <td class='p-0'> 
            <form action="" method='GET'>
                <button id='deleteShift' <?php echo "name=\"delete[$shiftName]\" "?> > <i class="fas fa-minus-circle fa-plus-circle"></i></button></td>
            </form>
            <?php
        if (isset($_GET['delete'])){
            $deletedShift = $_GET['delete'];
            $shifts->deleteShift();
        }
        ?>
        
    
        
        
        
        <td><?php echo $shiftName;
        ?><!-- here needs to be the shifts name --></td>
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
        <script>
        
        </script>
        <button class=''   type='button' ><i data-target='#newShiftEditor' data-toggle='collapse' data-toggle_class='fa-minus-circle' data-targeting='getting-hided' class="hiding-elements toggle-classes fas fa-plus-circle"></i></button>
    </td>


</tr>
</tbody>

</table>



</form>
<div id='newShiftEditor' class="collapse">
        <div class="container" >
            <table class='row'>    
                <tbody>
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
                <tr>
                <form action="" method='POST'>
                    <td><input name='shiftName' type="text"></td>
                    
                    <?php
                    for ($i=0; $i < 7; $i++) { 
                    ?>
                    <td>
                        <select name="daysOfWork[]">
                        <option value="1">On</option>
                        <option value="0">Off</option>
                        </select>
                    </td>
                    
                    <?php } ?>
                    
                </tr>
                <tr>
                   
                                <td>
                                
                                    <button   name='addNewShift' id='AddNewShiftB' class='rounded px-4 py-1 m-2  btn-success'>Add</button>
                                </form>
                                </td>
                            </tr>
                            <?php 
                    if (isset($_POST['addNewShift'])) {
                        $shiftName = $_POST['shiftName'];
                        $daysOfWork = implode(",", $_POST['daysOfWork']);
                        $createShift = new NewShifts($shiftName, $daysOfWork);
                        $createShift->buildShift();    
                    }
                    
                ?>

                
            </tbody>
            
        </table>
    
    </div>
    </div>
                
<h1 style='color:red;'>

</h1>
<button id='deleteSelected' name='deleteSelected' class='col-md-12 getting-hided btn-danger b1b2collapse'>Delete Selected</button>
<button id='submitOrder' name='submitOrder' class='col-md-12 getting-hided btn-primary b1b2collapse'>Submit Order</button>
</div>
<?php

if(isset($_GET['submitOrder'])){
    
    $submitions->createTable();
}

?>