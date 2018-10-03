    <?php
    session_start();
    require_once("Templates/mainHTMLHeader.html");
    require_once("methods_classes/DB_methods/DB_methods.php");
    require_once("methods_classes/dutyRosterClasses.php");

    $validate = new ValidateContent();

    ?>

    <?php 
    if(isset($_GET['action']) == "login"){
    ?>

    <!--Star of login section -->
    
    <main class="container">

                <?php

                if(isset($_POST['login'])){
                $usersEmail = $_POST['userEmail'];
                $usersPass = $_POST['usersPass'];
                if($validate->notEmpty($usersEmail, $usersPass)){
                    echo display_error("you need to fill all the fields");
                    }else{
                
                    $usersEmail = DB_real_escape($usersEmail);
                    $usersPass = DB_real_escape($usersPass);
                    if(DB_check_if_user_exist($usersPass, $usersEmail)){
                        if($usersEmail === "Admin"){
                            $_SESSION['Admin'] = "true";
                            header("location: adminsPanel.php");
                            exit;
                        }else if($userEmail !== "Admin"){
                            $_SESSION['fullName'] = $usersEmail;
                            header("location: index.php");
                            exit;
                        }
                    }else{
                        echo display_error("INVALID LOGIN!"); 
                    }
                }
            }
                ?>

                <?php include_once("Templates/loginTemplate.php"); ?>

    </main>
    <!-- END of login section -->

    <!--Star of Register section -->
    
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
            $errors = go_validate_user_input($fullName, $userEmail, $userPhone, $userPass, $passAgain);

            if(count($errors) === 0){
                    if(create_user($fullName, $userEmail, $userPhone, $userPass, $passAgain)){
                        $_SESSION['fullName'] = $fullName;
                        header("location: register.php?action=login");
                    } 
            }else{

                echo  "<div  id='error' class=\"alert alert-danger\" role=\"alert\">";
                        foreach ($errors as $key => $value) {
                            echo "$value <br>";
                        }
                        echo "</div>";
                    }
                }       
            ?>
                    
        <?php include_once("Templates/registerTemplate.php"); ?>

</main>

<?php
    }
?>
    <!-- END of Register section -->

<?php require_once("Templates/mainHTMLFooter.html"); ?>
