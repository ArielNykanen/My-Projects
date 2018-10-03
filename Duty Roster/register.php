    <?php require_once("mainHTMLHeader.html"); ?>
    <?php 
    $connect = mysqli_connect("localhost", "root", "", "registeredusersdr");
    session_start();
    $errors = []; #for collecting errors through the process's 
    #region checking for action
    if(isset($_GET['action']) == "login"){
    
    ?>  
    
    <main class="container">
                <?php if(isset($_POST['login'])){
                $usersEmail = $_POST['userEmail'];
                $usersPass = $_POST['usersPass'];
                if(empty($usersEmail)){
                    array_push($errors, "you didnt enter Email");
                }
                if(empty($usersPass)){
                    array_push($errors, "you didnt enter Password");
                }
                if(count($errors) > 0){
                    echo  "<div  id='error' class=\"alert alert-danger\" role=\"alert\">";
                    foreach ($errors as $key => $value) {
                        echo "$value <br>";
                    }
                    echo "</div>";
                }else{
                    $usersEmail = mysqli_real_escape_string($connect,$_POST['userEmail']);
                    $usersPass = mysqli_real_escape_string($connect,$_POST['usersPass']);
                    $usersPass = md5($usersPass);
                    $query = "SELECT * FROM `users` WHERE Email='$usersEmail' AND password='$usersPass'";
                    $result = mysqli_query($connect, $query);
                    if(mysqli_num_rows($result) == 1){
                        if($usersEmail === "Admin"){
                            $_SESSION['Admin'] = "true";
                            header("location: adminsPanel.php");
                            exit;
                        }elseif($userEmail !== "Admin"){
                            $_SESSION['fullName'] = $usersEmail;
                            header("location: index.php");
                            exit;
                        }
                    }else{
                        array_push($errors, "INVALID LOGIN");
            ?>
            <?php            echo "<div  id='error' class=\"alert alert-danger\" role=\"alert\">";
                        foreach ($errors as $key => $value) {
                            echo "$value <br>";
                        }
                        echo "</div>";
                    }
                }
                } ?>
                <h1 name='heade' id="head">Duty Roster Login</h1>
        <div id="whiteOpaBg">
            <div class="container" id="formWraper">
                <h3 align='center'>Login</h3>
	<form id="formInside" action='register.php?action=login' method='POST' enctype="multipart/form-data">
    <div class="form-group input-group">
    	<div class="input-group-prepend">
		    <span class="input-group-text"> <i class="fa fa-envelope"></i> </span>
		</div>
        <input name="userEmail" id='userEmail' class="form-control" placeholder="Email address" type="text" <?php if(isset($_POST['userEmail'])){echo "value=\"$_POST[userEmail]\"";}else{ echo "";} ?>>
    </div> 

    <div class="form-group input-group">
    	<div class="input-group-prepend">
		    <span  class="input-group-text"> <i class="fa fa-lock"></i> </span>
		</div>
        <input name='usersPass' id='usersPass' class="form-control" placeholder="Password" type="password" value="">
    </div> 
    	                                    
    <div class="form-group">
        <button name='login' type="submit" class="btn btn-primary btn-block"> Login </button>
    </div>       
    <p class="text-center">Not Registred? <a href="register.php">Register here</a> </p>                                                                 
    </form>
</div>
</div>
</main>
<?php
    if(isset($_POST['login'])){

}    

?>
<!-- Register section =================================================================================================== -->
    <?php
    }else{
        ?>
        <main name='main' class="container">
            <?php
        if(isset($_POST['register'])){
            $fullName = $_POST['fullName'];
            $userEmail = $_POST['userEmail'];
            $userPhone = $_POST['phoneNumber'];
            $userPass = $_POST['usersPass'];
            $passAgain = $_POST['userPassAgain'];
            if(empty($fullName)){
                array_push($errors, "you need to set the fullName please.");
            }
            if(empty($userEmail)){
                array_push($errors, "you need to set the Email please.");
            }
            if(empty($userPhone)){
                array_push($errors, "you need to set the phone number please.");
            }
            if(empty($userPass)){
                array_push($errors, "you need to set the password please.");
            }
            if(strlen($userPass) < 5 && !empty($userPass)){
                array_push($errors, "the password is too weak make more then 5 chars long please.");
            }
            if($userPass !== $passAgain){
                array_push($errors, "the two passwords don't match please re enter.");
            }
            $queryCheck = "SELECT * FROM `users` WHERE Email='$userEmail'";
            $result = mysqli_query($connect, $queryCheck);
            if(mysqli_num_rows($result) > 0){
                array_push($errors, "the email is allready registered!");
            }
            if(count($errors) === 0){
                $fullName = mysqli_real_escape_string($connect, $_POST['fullName']);
                $userEmail = mysqli_real_escape_string($connect, $_POST['userEmail']);
                $userPhone = mysqli_real_escape_string($connect, $_POST['phoneNumber']);
                $userPass = mysqli_real_escape_string($connect, $_POST['usersPass']);
                $userPass = md5($userPass);
                $query = "INSERT INTO users(FullName, Email, phoneNum, password) VALUES(
                '$fullName', '$userEmail', '$userPhone', '$userPass')";
                if(mysqli_query($connect, $query)){
                    $_SESSION['fullName'] = $fullName;
                    header("location: register.php?action=login");
                    echo "you have been registered!";
                }else{
                    echo "sorry there is a problem with the server currently try again in later.";
                }
                // $passAgain = mysqli_real_escape_string($connect, $_POST['userPassAgain']);   
            }else{
                ?>
        <?php 
                echo  "<div  id='error' class=\"alert alert-danger\" role=\"alert\">";
                        foreach ($errors as $key => $value) {
                            echo "$value <br>";
                        }
                        echo "</div>";
                    }
                }       
                        ?>
                    
                <h1 name='heade' id="head">Duty Roster Register</h1>
        <div id="whiteOpaBg">
            <div class="container" id="formWraper">
                <h3>Create Account</h3>
	<form id="formInside" action='register.php' method='POST' enctype="multipart/form-data">
	<div class="form-group input-group">
		<div class="input-group-prepend">
		    <span class="input-group-text"> <i class="fa fa-user"></i> </span>
		</div>
        <input name="fullName" id='fullName' class="form-control" placeholder="Full name" type="text" <?php if(isset($_POST['fullName'])){echo "value=\"$_POST[fullName]\"";}else{ echo "";} ?>>
    </div> 
    <div class="form-group input-group">
    	<div class="input-group-prepend">
		    <span class="input-group-text"> <i class="fa fa-envelope"></i> </span>
		</div>
        <input name="userEmail" id='userEmail' class="form-control" placeholder="Email address" type="email" <?php if(isset($_POST['userEmail'])){echo "value=\"$_POST[userEmail]\"";}else{ echo "";} ?>>
    </div> 
    <div class="form-group input-group">
    	<div class="input-group-prepend">
		    <span class="input-group-text"> <i class="fa fa-phone"></i> </span>
		</div>
    	<input name="phoneNumber" id='phoneNumber' class="form-control" placeholder="Phone number" type="text" <?php if(isset($_POST['phoneNumber'])){echo "value=\"$_POST[phoneNumber]\"";}else{ echo "";} ?>>
    </div>
    <div class="form-group input-group">
    	<div class="input-group-prepend">
		    <span  class="input-group-text"> <i class="fa fa-lock"></i> </span>
		</div>
        <input name='usersPass' id='usersPass' class="form-control" placeholder="Create password" type="password" value="">
    </div> 
    <div class="form-group input-group">
    	<div class="input-group-prepend">
		    <span class="input-group-text"> <i class="fa fa-lock"></i> </span>
		</div>
        <input name='userPassAgain' id='userPassAgain' class="form-control" placeholder="Repeat password" type="password" value="">
    </div>                                       
    <div class="form-group">
        <button name='register' type="submit" class="btn btn-primary btn-block"> Create Account  </button>
    </div>       
    <p class="text-center">Have an account? <a href="register.php?action=login">Log In</a> </p>                                                                 
    </form>
</div>
</div>
</main>
<?php
#endregion
} ?>
<?php require_once("mainHTMLFooter.html"); ?>
