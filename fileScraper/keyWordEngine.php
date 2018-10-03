<?php
if(isset($_FILES['usersfile']) && $_POST['keyWord'] !== ''){
    $uploadedFIlesLocation = "scrapedFiles/";
    $usersKeyWord = $_POST['keyWord'];
    $usersFile = $_FILES['usersfile']['name'];
    $tem_usersFile = $_FILES['usersfile']['tmp_name'];
    $usersFile_type = $_FILES['usersfile']['type'];
    $usersFile_error = $_FILES['usersfile']['error'];


    #checking some condition's=======================
    for ($i=0; $i < count($tem_usersFile); $i++) { 
        if($usersFile_error[$i] > 0){
            echo "<h1 style='margin:0px;color:red;'>there was error uploading $usersFile[$i] try again please.</h1>";
            return;
        };
        if($usersFile_type[$i] !== "text/plain"){
            echo "<h1 style='margin:0px;color:red;'>app supports only txt files and was given $usersFile[$i] cannot continue scraping.<h1><br>";
            return;
        }
    }



    #moving the users files to scrapedFiles folder===========================
    for($j = 0; $j < count($tem_usersFile); $j++){
        move_uploaded_file($tem_usersFile[$j],"scrapedFiles/".$usersFile[$j]);
    }


    #search for matches and echo results=======================
    echo "<div id='results' style='border:1px solid;max-width:300px;'>
    <h4>Search results</h4>
    ";
    for ($k=0; $k < count($tem_usersFile); $k++) { 
        $scrapIt = file("$uploadedFIlesLocation$usersFile[$k]");
        $scrapIt = implode($scrapIt);
        if(preg_match("/$usersKeyWord/",$scrapIt)){
            echo "<div style='border:1px solid;'><span style='color:green;'>$usersKeyWord match in $usersFile[$k]</span><br>";
            echo"</div>";
        }
    }
    echo "</div>";
}

?>