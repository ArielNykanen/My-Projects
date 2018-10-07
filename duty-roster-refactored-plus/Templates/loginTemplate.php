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