<?php session_start(); ?>
<?php require_once('mainHTMLHeader.html'); ?>
<script>
<?php echo "document.body.setAttribute('style', 'background-image: url(images/MainBg.jpg);');"; ?>
</script>
<?php
$errors = [];

if($_SERVER['QUERY_STRING'] === "action=exit"){
    $_SESSION['fullName'] = NULL;
    header("location: register.php?action=exit");
    exit;
}
?>

<div id="requestWraper" class="container">
    <div class="row">
    <div class="col-md-12">
            <i id='cross' class="fas fa-chevron-circle-left"></i>
</div>
        <div class="col-md-12">
<h4>Send Request To Manager</h4>
</div>
<div class="col-md-12">
<select name="requesting">
    <option value="vication">
        Vication
    </option>
    <option value="other">
        Other
    </option>
</select>
</div>
<div class="col-md-12">
    <h5>Write A Note</h5>
<textarea name="requestDetails" cols="30" rows="5" placeholder='write the Reason/Other'></textarea>
</div>
<div class="col-md-12">
    <button class='btn-primary'>Submit</button>
</div>
</div>
</div>

<?php
if($_SERVER['QUERY_STRING'] === "action=request"){
}

if(isset($_SESSION['fullName'])){
?>

<?php require_once('navBar.php'); ?> 

<h4 id='loggedInAs'>Logged In</h4>
<main>
<h1>Duty Ruster</h1>
<form id='sendRef' action="index.php" method="GET">
<table>
<thead>
    <th>
    Sunday
    </th>
    <th>
    Monday
    </th>
    <th>
    Tuesday
    </th>
    <th>
    Wednesday
    </th>
    <th>
    Thursday
    </th>
    <th>
    Friday
    </th>
    <th>
    Saturday
    </th>
</thead>

<tbody >
    <?php 

    for ($i=0; $i <= 5; $i++) { 
        switch ($i) {
            case 0:
            $day = "Sunday";
            continue;
            case 1:
            $day = "Monday";
            continue;
            case 2:
            $day = "Tuesday";
            continue;
            case 3:
            $day = "Wednesday";
            continue;
            case 4:
            $day = "Thursday";
            continue;
            case 5:
            $day = "Friday";
            continue;
        }
        echo "<td>
        <select class='sellectPre form-control selcls' name=\"sellectPre[]\" id=\"\">
            <option value=\"1\">
                Morning
            </option>
            "; if($i !== 5){
                echo  "
            <option value=\"2\">
                Eavning
            </option>
            <option value=\"3\">
            Both
            </option>
            <option value=\"0\">
            Freeday
            </option>";
        }else{
            echo "
            <option value=\"0\">
            Freeday
            </option>";
        }
        echo"
        </select>
        </td>";
    }
    ?>
</tbody>
</table>
<fieldset id='fieldset'>
<legend>Extra info for the week</legend>
<?php
$connect = mysqli_connect("localhost","root","","registeredusersdr");
    $getMessage = "SELECT mesage FROM admins";
    $results = mysqli_query($connect, $getMessage);
    $message = mysqli_fetch_array($results);
    if($message && count($message) > 0){
        $importantM = $message[0];
        echo "<strong style='color:rgb(23, 182, 12);'>$importantM</strong>";
    }else{
    echo "<strong style='color:rgb(233, 182, 102);'>The manager didn't updated any news yet...</strong>";
}
    ?>

</fieldset>
    <?php    
    $connect = mysqli_connect("127.0.0.1", "root", "","registeredUsersdr");
    $Email = $_SESSION['fullName'];
    $queryCheck = "SELECT * FROM `submitions` WHERE Email='$Email'";
    $result = mysqli_query($connect, $queryCheck);
    if(isset($_GET['submitD']) && mysqli_num_rows($result) > 0){
        array_push($errors, "You all ready submited!<br>
        Contact your manager for more details.");
    }
if(isset($_GET['submitD'])){
    $selection = $_GET['sellectPre'];
    $temp = 0;
    for ($i=0; $i < count($selection); $i++) { 
        if($selection[$i] === '3'){
        $temp++;
        }
    }
    if($temp < 3){
        array_push($errors, "You need to chose at least 3 time Both, <br>
        For other options please contact your manager.");
    }
    if(count($errors) > 0){
        foreach ($errors as $key => $value) {
            echo "<strong style='font-size:20px;'>$value</strong>";
        }
        echo "<button id='submition' name='submitD' class='btn-primary'>Submit</button>";
        return;
    }
    echo "<h4>Submited</h4>";
    $connect = mysqli_connect("127.0.0.1", "root", "","registeredUsersdr");
    echo "<br>";
    echo "Submited your scedual for the next week you will be updated soon as there is an update!";
    $Email = $_SESSION['fullName'];
    $sub = $selection;
    $sub = implode(",",$sub);
    $Email = mysqli_real_escape_string($connect,$Email);
    $query = "INSERT INTO submitions(Email,submition) VALUES('$Email' ,'$sub');";
    if(mysqli_query($connect, $query)){
        echo "<br>submited successfuly!";
    }else{
        echo "something is wrong";
    }
    ?>
    <button id='submition' name='submitD' class='btn-primary'>Submit</button>
<?php 
    echo "<script>document.getElementById('submition').remove()</script>";
}else{
    echo "<button id='submition' name='submitD' class='btn-primary'>Submit</button>";
}
?>
</form>

</main>

<?php }else{
    header("location: register.php");
    }?>
<script>
<?php require("requestPanel.js") ?>
</script>

<?php require_once('mainHTMLFooter.html'); ?>