<?php

require_once('methods_classes/workers_panel/workers_classes.php'); 
    require_once('methods_classes/workers_panel/workers_methods.php'); 
    require_once('methods_classes/DB_methods/DB_methods.php');  
    require_once('methods_classes/DB_classes/DB_classes.php');  
    $requests = new Worker($_SESSION['fullName'],"","");
    ?>
    
<form method="POST">


<!-- dont forget to echo the end of the form -->

<div id="requestWraper" class="container">
<?php

if($requests->getRequest()){

?>
    <div class="col-md-12">
            <i id='cross' class="fas fa-chevron-circle-left"></i>
    </div>
<?php

        ?>
        <form action="" method='POST'>
        <h4>Your question</h4>
        <?php echo $requests->getQuestion(); ?>
        <h4>Your Answer</h4>
        <strong>Manager</strong>:<?php 
        if($requests->getAnswer()){
            
            echo $requests->getAnswer();
            ?>
            
            <button name='deleteRequest' class='btn-success'>Confirm</button>
            <?php
        
        }else{
            
            echo $yourRequestMessage;
            
    }

?>
            <button name='deleteRequest' class='btn-danger'>Delete Request</button>
            </form>

<?php
if(isset($_POST['deleteRequest'])){

    $requests->deleteRequest();

}

}else{



?>
    <div class="row">
    <div class="col-md-12">
            <i id='cross' class="fas fa-chevron-circle-left"></i>
</div>
        <div class="col-md-12">
<h4><?php echo $requestTab->header; ?></h4>
</div>

<div class="col-md-12">
    <h5><?php echo $requestTab->header2; ?></h5>
<textarea name="requestDetails" cols="30" rows="5" placeholder='<?php echo $requestTab->message3; ?>' maxlength='500'></textarea>
</div>
<div class="col-md-12">
<?php


if(isset($_POST['sendRequest'])){
    if(!empty($_POST['requestDetails'])){

    $newRequest = new Worker($_SESSION['fullName'], $_POST['requestDetails'], "");
    $newRequest->setRequest();

    }else{
        echo "you didnt write any shit";
    }

}

?>


<button class='btn-primary' name='sendRequest'><?php echo $requestTab->submit; ?></button>
</div>
</div>
<?php
}
?>
</div>
</form>

