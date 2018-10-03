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