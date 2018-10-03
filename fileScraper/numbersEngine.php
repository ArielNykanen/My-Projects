<?php

if(isset($_FILES['usersfile']) && $_POST['numSellector'] !== ''){
    $uploadedFIlesLocation = "scrapedFiles/";
    $firstNums = $_POST['numSellector'];
    $usersFile = $_FILES['usersfile']['name'];
    $tem_usersFile = $_FILES['usersfile']['tmp_name'];
    $usersFile_type = $_FILES['usersfile']['type'];
    $usersFile_error = $_FILES['usersfile']['error'];
    $matchesHolderArr = [];

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
}

$numRegex = "/($firstNums|\($firstNums\))(-|\.|\/|)(\d{7})|($firstNums|\($firstNums\))(-|\.|\/|)(\d{3})(-|\.|\/)(-|\.|\/|)(\d{4})/";

echo "<div style=\"border:1px solid;\">
    <h3>Results</h3>";
for ($i=0; $i < count($usersFile); $i++) { 
    move_uploaded_file($tem_usersFile[$i],"getNumsScraped/".$usersFile[$i]);
    $checkArr = file("getNumsScraped/$usersFile[$i]");
    preg_match($numRegex, $checkArr[0], $matches);
    if(isset($matches[0])){
        echo "<span style='color:green;'>$matches[0]</span><br>";
        $save = fopen('matches.txt',"a");
        fputs($save, $matches[0]."\n");
        fclose($save);
    }
}
echo "</div>";
?>