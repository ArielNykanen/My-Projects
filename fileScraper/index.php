
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
    <link rel="stylesheet" href="main.css">
    <title>Document</title>
</head>
<body class="container">
    <div id="intro"></div>
<?php $title = "File Scraper"; include("header.php"); ?>

<main id='main' class='container' style='min-height:820px;'>
<form action="index.php" method='POST' enctype="multipart/form-data">
    <div class="row">
        <div id='upload' class="col-md-12">
            <label>
                <input name='usersfile[]' type="file" multiple="">
            </label>
        </div>
        <div id='keyInput' class="col-md-11">
            <label>Search
                <input   id='keyWord' type="text" name='keyWord'>
            </label>
        </div>
        <div class="col-md-12">
            <input id='search' type="submit" value="Search">
        </div>
    </div>
</form>

    <?php include("keyWordEngine.php"); ?>


</main>
<?php $copy = "© 2018 Ariel Nykänen"; include("footer.php"); ?>
<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/mustache.js/2.3.2/mustache.js"></script>
<script src="temps.js"></script>
<script src="main.js"></script>
</body>
</html>