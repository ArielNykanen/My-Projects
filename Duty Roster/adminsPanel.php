<?php 
$messageToAll = 'The manager didnt update yet any messages...';
?>
<?php require_once("mainHTMLHeader.html"); ?>
<?php require_once('adminsNav.php'); ?>

<script>
<?php require_once("adminsPanel.js") ?>
</script>

<div id='managersMessage'>
<h2>"What you do has far greater impact than what you say."</h2>
</div>
<div id='adminAlerts'>
    <h2 >Worker Status</h2>
    <div id='submited'>
    <h5>Submited</h5>
    <ul>
    <?php
    #region ----collecting data from Db 
$connect = mysqli_connect("localhost", "root", "", "registeredusersdr");
$workers = "SELECT FullName,Email  FROM users;";
$sWorkers = "SELECT Email FROM submitions;";
$result1 = mysqli_query($connect, $workers);
$result2 = mysqli_query($connect, $sWorkers);
$allWorkers = [];
$submitedWorkers = [];
while ($user = mysqli_fetch_array($result1)) {
    $allWorkers[] = $user['Email']; 
}
while ($user = mysqli_fetch_array($result2)) {
    $submitedWorkers[] = $user['Email'];
}
#endregion ----collecting data from Db

#region ----fetching all the user's who was submited to duty and deleting them from didnt submit list
for ($j = 0;$j < count($allWorkers);$j++) {
    for ($i=0; $i < count($submitedWorkers); $i++) { 
        if($allWorkers[$j] === $submitedWorkers[$i]){
            $worker = "SELECT FullName FROM users WHERE Email = '$submitedWorkers[$i]'";
            $temp = mysqli_query($connect, $worker);
            $res = mysqli_fetch_array($temp);
            echo "<li>$res[0]</li>";
            array_splice($allWorkers,$j,1);
        }
    }
}
#endregion ----fetching all the user's who was submited to duty and deleting them from didnt submit list
?>
</ul>
    </div>
    <div id='notsubmited'>
    <h5>Didn't Submit</h5>
    <ul>
    <?php
    foreach ($allWorkers as $key => $value) {
            if($value === "Admin"){
                continue;
            }
            $worker = "SELECT FullName FROM users WHERE Email = '$value'";
            $temp = mysqli_query($connect, $worker);
            $res = mysqli_fetch_array($temp);
            echo "<li>$res[0]</li>"; 
    }
    ?>
    </ul>
    </div>
</div>
<?php if(isset($_POST['sendImportan'])){
    $importantM = $_POST['importantM'];
    $query = "INSERT INTO admins(mesage) VALUES('$importantM')";
    $delete = "DELETE FROM admins WHERE id";
    mysqli_query($connect, $delete);
    if(empty($_POST['importantM'])){
        echo "<div class=\"alert alert-danger alert-dismissible\">
        <a href=\"#\" class=\"close\" data-dismiss=\"alert\" aria-label=\"close\">&times;</a>
        <strong>You didn't write anything!</strong>
    </div>";
    }elseif(mysqli_query($connect, $query)){
        echo "<div class=\"alert alert-success alert-dismissible\">
        <a href=\"#\" class=\"close\" data-dismiss=\"alert\" aria-label=\"close\">&times;</a>
        <strong> Submited successfully!</strong>
    </div>";
    }
}

?>
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
    <textarea name="importantM" id="importantM" cols="30" rows="5" placeholder='Write somthing important about the next week for example...'></textarea>
</div>
<div class="col-md-6">
    <button class='btn-success' name='sendImportan'>Send To All</button>
</div>
</form>
<div class="col-md-12">
    <h5>Current Message</h5>
</div>
<div class="col-md-12">
    <p>
    <?php
    $getMessage = "SELECT mesage FROM admins";
    $results = mysqli_query($connect, $getMessage);
    $message = mysqli_fetch_array($results);
    if($message && count($message) > 0){
        $importantM = $message[0];
        echo "<strong style='color:rgb(23, 182, 12);'>$importantM</strong>";
    }else{
    echo "<strong style='color:rgb(233, 182, 102);'>you didn't submit any messages submit now and all employs will have it on there dashBoard!</strong>";
}
    ?>
    
    </p>
</div>

</div>
</div>

<h1 id='MPh1'>Managers Panel</h1>
<div id='makeRwraper' class="container">
    <form action="adminsPanel.php">
    <div class="row">
        <div class="col-md-12" style='max-height:100px;'>
            <h3>Make The Duty Roster</h3>
        </div>
        <div class="col-md">
            <table id='Mtable'>
                <thead>
                    <th>Time</th>
                    <th>Sunday</th>
                    <th>Monday</th>
                    <th>Tuesday</th>
                    <th>Wednesday</th>
                    <th>Thursday</th>
                    <th>Friday</th>
                    <th>Saturday</th>
                </thead>
                <tbody>
                    <tr>
                    <?php 
                    $sunDay = [];
                    $monDay = [];
                    $tuesDay = [];
                    $wednesDay = [];
                    $thursDay = [];
                    $friDay = [];
                    foreach ($submitedWorkers as $key => $value) {
                        $worker = "SELECT Submition FROM submitions WHERE Email = '$value'";
                        $temp = mysqli_query($connect, $worker);
                        $res = mysqli_fetch_array($temp);
                        $res = preg_split('/,/', $res[0]);
                        for ($i=0; $i < count($res); $i++) { 
                            if($res[$i] === '1' || $res[$i] === '3'){
                                $worker1 = "SELECT FullName FROM users WHERE Email = '$value'";
                                $temp1 = mysqli_query($connect, $worker1);
                                $res1 = mysqli_fetch_array($temp1);
                                if($i === 0){
                                    
                                    array_push($sunDay, $res1[0]);
                                    
                                };
                                if($i === 1){
                                    $monDay[] = $res1[0];
                                };
                                if($i === 2){
                                    $tuesDay[] = $res1[0];
                                };
                                if($i === 3){
                                    $wednesDay[] = $res1[0];
                                };
                                if($i === 4){
                                    $thursDay[] = $res1[0];
                                };
                                if($i === 5){
                                    $friDay[] = $res1[0];
                                };
                            }
                        }
                    }
                    
                    ?>
                    <td id='morningTD'>Morning</td>
                    <td id='sMorning'><?php if(isset($sunDay)){
                        foreach ($sunDay as $key => $value) {
                            echo $value . "<br>";
                        }
                    } ?>
                    </td>
                    <td id='mMorning'><?php if(isset($monDay)){
                        foreach ($monDay as $key => $value) {
                            echo $value . "<br>";
                        }
                    } ?></td>
                    <td id='tuMorning'><?php if(isset($tuesDay)){
                        foreach ($tuesDay as $key => $value) {
                            echo $value . "<br>";
                        }
                    } ?></td>
                    <td id='wMorning'><?php if(isset($wednesDay)){
                        foreach ($wednesDay as $key => $value) {
                            echo $value . "<br>";
                        }
                    } ?></td>
                    <td id='thMorning'><?php if(isset($thursDay)){
                        foreach ($thursDay as $key => $value) {
                            echo $value . "<br>";
                        }
                    } ?></td>
                    <td id='fMorning'><?php if(isset($friDay)){
                        foreach ($friDay as $key => $value) {
                            echo $value . "<br>";
                        }
                    } ?></td>
                    <td class='saturday'></td>
                    
                    </tr>
                    <?php 
                    $sunDay = [];
                    $monDay = [];
                    $tuesDay = [];
                    $wednesDay = [];
                    $thursDay = [];
                    $friDay = [];
                    foreach ($submitedWorkers as $key => $value) {
                        $worker = "SELECT Submition FROM submitions WHERE Email = '$value'";
                        $temp = mysqli_query($connect, $worker);
                        $res = mysqli_fetch_array($temp);
                        $res = preg_split('/,/', $res[0]);
                        for ($i=0; $i < count($res); $i++) { 
                            if($res[$i] === '2' || $res[$i] === '3'){
                                $worker1 = "SELECT FullName FROM users WHERE Email = '$value'";
                                $temp1 = mysqli_query($connect, $worker1);
                                $res1 = mysqli_fetch_array($temp1);
                                if($i === 0){
                                    $sunDay[] = $res1[0];
                                };
                                if($i === 1){
                                    $monDay[] = $res1[0];
                                };
                                if($i === 2){
                                    $tuesDay[] = $res1[0];
                                };
                                if($i === 3){
                                    $wednesDay[] = $res1[0];
                                };
                                if($i === 4){
                                    $thursDay[] = $res1[0];
                                };
                                if($i === 5){
                                    $friDay[] = $res1[0];
                                };
                            }
                        }
                    }
                    ?>
                    <tr>
                        <td id='eveningTD'>Evening</td>
                        <td id='sMorning'><?php if(isset($sunDay)){
                        foreach ($sunDay as $key => $value) {
                            echo "<strong>$value</strong><br>";
                        }
                    } ?>
                    </td>
                    <td id='mMorning'><?php if(isset($monDay)){
                        foreach ($monDay as $key => $value) {
                            echo "$value <br>";
                        }
                    } ?></td>
                    <td id='tuMorning'><?php if(isset($tuesDay)){
                        foreach ($tuesDay as $key => $value) {
                            echo $value . "<br>";
                        }
                    } ?></td>
                    <td id='wMorning'><?php if(isset($wednesDay)){
                        foreach ($wednesDay as $key => $value) {
                            echo $value . "<br>";
                        }
                    } ?></td>
                    <td id='thMorning'><?php if(isset($thursDay)){
                        foreach ($thursDay as $key => $value) {
                            echo $value . "<br>";
                        }
                    } ?></td>
                    <td id='fMorning'><?php if(isset($friDay)){
                        foreach ($friDay as $key => $value) {
                            echo $value . "<br>";
                        }
                    } ?></td>
                        <td class='saturday'></td>
                    </tr>
            </tbody>
            </table>
            
            </div>
            <div class="col-md-12">
                <button class='btn-success'>Create</button>
            </div>            
        </div>
    </form>
</div>


<?php



?>



<?php require_once("mainHTMLFooter.html"); ?>
