let $TEMP_intro = function(){
    return`
    <strong><h1>Welcome To File Scraper</h1></strong>
    <h3>instructions</h3>
        <p>chose as many file's as you want to scrap</p>
        <p>The app will save the result's to Matche's folder and if you use the find phone Number's future <br> then it will save the content to matches.txt file if there was a match</p>
        <p>The app will show you the progress live and when the procces is completed</p>
        <p>Have fun exploring the app :)</p>
        <button id='closeIntro'>Close</button>
    `
}
let $TEMP_numberSearch = function(){
    return`<form action="numsScrap.php" method='POST' enctype="multipart/form-data">
    <div class="row">
    <div id='upload' class="col-md-12">
    <label>
        <input name='usersfile[]' type="file" multiple="">
    </label>
</div>
    <h1>Search Phone Number</h1>
        <div id='keyInput' class="col-md-11">
        <label>Tel types
        </label>
        <select name="phoneNum">
            <option value="057">057</option>
            <option value="054">054</option>
            <option value="053">053</option>
            <option value="052">052</option>
            <option value="050">050</option>
        </select>
        </div>
        <div class="col-md-12">
            <input id='search' type="submit" value="Search">
        </div>
    </div>
</form>
<?php include("numbersEngine.php"); ?>
    `
}

let $TEMP_keySearch = function(){
    return`
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
    `
}