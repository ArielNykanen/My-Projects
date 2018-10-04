<?php

interface IDisplayText{
function execute();
}


class DisplayingText implements IDisplayText {

private $header;
private $message;

public function __construct($header, $message) {
    $this->header = $header;
    $this->message = $message;
}
function execute(){
    echo $this->__toString();
}

public function __toString(){

    return "<strong style='color:rgb(255, 255, 255)';> $this->header </strong>";
    
}

}


class SubmitionMessage extends DisplayingText{
public $header;
public $successMessage;

public function __construct($header, $successMessage) {
    $this->header = $header;
    $this->successMessage = $successMessage;
}


function execute(){

    echo $this-> __toString();

}

public function __toString(){

    return"
<div class=\"alert alert-success alert-dismissible\">
<a href=\"#\" class=\"close\" data-dismiss=\"alert\" aria-label=\"close\">&times;</a>
<h4>$this->header</h4>
<br>
<strong>$this->successMessage</strong>
</div>";

}

}







class LogedInMessage extends DisplayingText{

public function __construct($message) {
    $this->message = $message;
}

function execute(){

    echo $this-> __toString();

}

public function __toString(){

    return $this->message;

}


}


class UsersSubmitionOnHoldHeaderMessage extends DisplayingText{

public $submitedHeader;

public function __construct($submitedHeader) {
    $this->submitedHeader = $submitedHeader;
}

function execute(){

    echo $this-> __toString();

}

function __get($message){

    return $this->submitedHeader;

}

public function __toString(){

    return $this->submitedHeader;

}


}


$loggedInMessage = new  LogedInMessage("");


class Submit extends DisplayingText{

public function __construct($message) {
    $this->message = $message;
}

function execute(){

    $lang = $this->getLanguage();
    echo $lang-> __toString();

}

public function __toString(){

    return  $this->message;

}

}


class RequestTab extends DisplayingText {

private $header2;
private $message2;
private $message3;
private $submit;

public function __construct($header, $message, $header2, $message2, $message3, $submit) {

    $this->header = $header;
    $this->message = $message;
    $this->message2 = $message2;
    $this->message3 = $message3;
    $this->header2 = $header2;
    $this->submit = $submit;

}

public function __get($requested){

    return $this->$requested;

}


}


class DisplayError extends DisplayingText {

public $errMessage;

public function __construct($header, $errMessage) {
    $this->header = $header;
    $this->errMessage = $errMessage;  

}

public function execute(){

    echo $this->__toString();

}

public function __toString(){

    return "
    <div id=\"errorAlert\" class=\"alert alert-danger alert-dismissible\">
<a href=\"#\" class=\"close\" data-dismiss=\"alert\" aria-label=\"close\">&times;</a>
<h4>$this->header</h4>
<br>
<strong>$this->errMessage</strong>
</div>";

}


}


class Create_th {

    private $day1;
    private $day2;
    private $day3;
    private $day4;
    private $day5;
    private $day6;
    private $day7;

    public function __construct($day1, $day2, $day3, $day4, $day5, $day6, $day7) {
        $this->day1 = $day1;
        $this->day2 = $day2;
        $this->day3 = $day3;
        $this->day4 = $day4;
        $this->day5 = $day5;
        $this->day6 = $day6;
        $this->day7 = $day7;
    }

    public function execute(){
        
        echo  $this->__toString();

    }

    public function __get($name){

        return $this->$name;

    }

    public function __toString(){
        return"
      
        <thead>
        <th>
        
        $this->day1
        </th>
        <th>
        
        $this->day2
        </th>
        <th>
        
        $this->day3
        </th>
        <th>
        
        $this->day4
        </th>
        <th>
        
        $this->day5
        </th>
        <th>
        
        $this->day6
        </th>
        <th>
        
        $this->day7
        </th>
        </thead>
                    ";

        
}
}

class AdminsThead extends Create_th{

    protected $dayType;
    protected $edit;

    public function __construct($day1, $day2, $day3, $day4, $day5, $day6, $day7, $dayType, $edit) {
        
        $this->day1 = $day1;
        $this->day2 = $day2;
        $this->day3 = $day3;
        $this->day4 = $day4;
        $this->day5 = $day5;
        $this->day6 = $day6;
        $this->day7 = $day7;
        $this->dayType = $dayType;
        $this->edit = $edit;

    }

    public function execute(){
        
        echo  $this->__toString();

    }

    public function __get($name){

        return $this->$name;

    }

    public function __toString(){
        return"
        <div class=\"container\">
        <thead>
        <th>
        $this->edit
        </th>
        <th>
        $this->dayType
        </th>
        <th>
        $this->day1
        </th>
        <th>
        $this->day2
        </th>
        <th>
        $this->day3
        </th>
        <th>
        $this->day4
        </th>
        <th>
        $this->day5
        </th>
        <th>
        $this->day6
        </th>
        <th>
        $this->day7
        </th>
        </thead>
        </div>";

        
}

}


class NavLang {

    private $Request;
    private $LogOut;

    public function __construct($Request, $LogOut) {

        $this->Request = $Request;
        $this->LogOut = $LogOut;

    }

    public function __get($type){

        return $this->$type;

    }

}

class AdminsNav extends NavLang {
    
    protected $WorkerRequests;
    protected $AdminsPanel;

    
    
    public function __construct($WorkerRequests, $LogOut, $AdminsPanel) {

        $this->WorkerRequests = $WorkerRequests;
        $this->LogOut = $LogOut;
        $this->AdminsPanel = $AdminsPanel;

    }

    public function __get($type){

        return $this->$type;

    }

}


#region ----App's workers panel language creation 

class Languages {

    protected $languages; 

    public function __construct($languages) {
        $this->languages = $languages;
    }


    public function setLang(){

        $select = '';
        if(isset($_GET['langSelection']))

                $_SESSION['select'] = $_GET['langSelection'];

                if(isset($_SESSION['select'])){
                    
                    $select = $_SESSION['select'];
                    $this->createSellections($select); 

                }else

                    $this->createSellections($select); 

    }


    public function createSellections($select){

        $options = "";

        foreach ($this->languages as $key => $value) {

            if($select == $value){

                $options.='<option value="' . $value . '" selected>' .$key . '</option>';
                
            }else{

                $options.='<option value="' . $value . '">' .$key . '</option>';

            }

        }
    
        echo $options;
    }


    


    function getLanguage(){
        foreach ($this->languages as $key => $value) {

            if($_SERVER['QUERY_STRING'] === "langSelection=$value"){
                $this->$key();
                return;
            }
                
        }
        $this->English();
        return;
            
        }
        
        
        function English(){
            
            $GLOBALS['minimumErrNotUpdated'] = new DisplayError("Not updated!","You didnt reached minimum requirements, for other options contact your manager.");
            $GLOBALS['minimumNotReached'] = new DisplayError("error!","You didnt reached minimum requirements, for other options contact your manager.");
            $GLOBALS['adminsThead'] = new AdminsThead("Sunday", "Monday", "Tuesday", "Wednesday", "Thursday", "Friday", "Saturday", "Shift", "Edit"); 
            $GLOBALS['yourRequestMessage'] = new DisplayingText("your request is on hold.","");
            $GLOBALS['mainWorkerPanelHeader'] = new DisplayingText("Duty Roster","");
            $GLOBALS['submitionSuccessMessage'] = new SubmitionMessage("Submited!","Your work order has been submitted successfully");
            $GLOBALS['allReadySubmitedMessage'] = new DisplayError("error!","You have already sent a work order,<br> to change the constraints please contact your administrator.");
            $GLOBALS['extraInfo'] = new DisplayingText("Extra info for the week", "");
            $GLOBALS['defaultMessage'] = new DisplayingText("The manager didn't updated any news yet", "");
            $GLOBALS['requestTab'] = new RequestTab("Send Request To Manager", "vacation", "Request Details", "other", "write here the details for the Request", "Submit");
            $GLOBALS['Thead'] = new Create_th("Sunday", "Monday", "Tuesday", "Wednesday", "Thursday", "Friday", "Saturday"); 
            $GLOBALS['loggedInMessage'] = new LogedInMessage("Logged In As: ");
            $GLOBALS['submitedTable'] = new UsersSubmitionOnHoldHeaderMessage("Pending Work Arrangement<br> You will receive an update soon as the work arrangement will be ready for the next week.");
            $GLOBALS['Submit'] = new Submit("Submit");
            $GLOBALS['Update'] = new Submit("Update Change");
            $GLOBALS['navLang'] = new NavLang("Request", "LogOut");
            #region ----adminsPanelLang 
            
            $GLOBALS['adminsNav'] = new AdminsNav("Workers Requests", "LogOut", "AdminsPanel");
            
            #endregion ----adminsPanelLang
            // $GLOBALS[''] = new ("");
            
        }
        
        function Hebrew(){
            
            $GLOBALS['minimumErrNotUpdated'] = new DisplayError("לא התעדכן","לא בחרת במינימום משמרות לשבוע, לאפשרויות אחרות אנא פנה למנהל שלך.");
            $GLOBALS['minimumNotReached'] = new DisplayError("תקלה בשליחה","לא בחרת במינימום משמרות לשבוע, לאפשרויות אחרות אנא פנה למנהל שלך.");
            $GLOBALS['adminsThead'] = new AdminsThead("ראשון", "שני", "שלישי", "רביעי", "חמישי", "שישי", "שבת", "משמרת"); 
            $GLOBALS['yourRequestMessage'] = new DisplayingText(".הבקשה שלך בהמתנה","");
            $GLOBALS['mainWorkerPanelHeader'] = new DisplayingText("סידור עבודה","");
            $GLOBALS['submitionSuccessMessage'] = new SubmitionMessage("!נשלח","!הסידור עבודה נשלח בהצלחה");
            $GLOBALS['allReadySubmitedMessage'] = new DisplayError("!שגיאה", "כבר שלחת סידור עבודה, לשינוי האילוצים אנא פנה למנהל שלך ");
            $GLOBALS['extraInfo'] = new DisplayingText("מידע נוסף לשבוע", "");
            $GLOBALS['defaultMessage'] = new DisplayingText("המנהל לא עידכן מידע חדש לשבוע הבא", "");
            $GLOBALS['requestTab'] = new RequestTab("שליחת בקשה למנהל", "חופש", "פירוט הבקשה", "אחר", "רשום כאן פירוט לבקשה", "שלח");
            $GLOBALS['Thead'] = new Create_th("ראשון", "שני", "שלישי", "רביעי", "חמישי", "שישי", "שבת"); 
            $GLOBALS['loggedInMessage'] = new LogedInMessage(" מחובר/ת ");
            $GLOBALS['submitedTable'] = new UsersSubmitionOnHoldHeaderMessage(" הסידור עבודה בהמתנה תעודכן שיוגש סידור לשבוע הבא ");
            $GLOBALS['Submit'] = new Submit("הגש סידור");
            $GLOBALS['navLang'] = new NavLang("בקשה", "התנתק");
            $GLOBALS['Update'] = new Submit("עדכן שינוי");
            #region ----adminsPanelLang 
            
            $GLOBALS['adminsNav'] = new AdminsNav("בקשות של עובדים", "התנתק", "לוח מנהלים");
            
            #endregion ----adminsPanelLang
            // $GLOBALS[''] = new ("");
            
        }
        
        function Finnish(){
            
            $GLOBALS['adminsThead'] = new AdminsThead("Sunnuntai", "Maanantai", "Tiistai", "Keskiviikko", "Torstai", "Perjantai", "lauantai", "aika"); 
            $GLOBALS['yourRequestMessage'] = new DisplayingText("Pyyntösi on vireillä.","");
            $GLOBALS['mainWorkerPanelHeader'] = new DisplayingText("Työjärjestely","");
            $GLOBALS['submitionSuccessMessage'] = new SubmitionMessage("toimitettu!","Työjärjestys lähetettiin onnistuneesti!!");
            $GLOBALS['allReadySubmitedMessage'] = new DisplayError("Virhe!", "Olet jo lähettänyt työjärjestyksen,<br> jos haluat muuttaa rajoituksia,<br> ota yhteyttä järjestelmänvalvojaasi.");
            $GLOBALS['extraInfo'] = new DisplayingText("Lissaa tietoaa ens viikolle", "");
            $GLOBALS['defaultMessage'] = new DisplayingText("Johtaja ei ole päivittänyt mitään uutisia", "");
            $GLOBALS['requestTab'] = new RequestTab("Lähetä pyyntö managerille", "lomaa", "Kirjoita huomautus", "muuta", "Ilmoita pyyntösi täältä", "Lähetä");
            $GLOBALS['Thead'] = new Create_th("Sunnuntai", "Maanantai", "Tiistai", "Keskiviikko", "Torstai", "Perjantai", "lauantai"); 
            $GLOBALS['loggedInMessage'] = new LogedInMessage("Kirjautunut sisään nimellä: ");
            $GLOBALS['submitedTable'] = new UsersSubmitionOnHoldHeaderMessage("Odottava työjärjestely <br> Saat päivityksen heti, kun työjärjestely on valmis seuraavalle viikolle. ");
            $GLOBALS['Submit'] = new Submit("Lähetä");
            $GLOBALS['Update'] = new Submit("Päivitä muutos");
            $GLOBALS['navLang'] = new NavLang("Pyyntö", "Kirjautua ulos");

            #region ----adminsPanelLang 
            
            $GLOBALS['adminsNav'] = new AdminsNav("Työntekijöiden pyynnöt", "Kirjautua ulos", "Hallitus");
            
            #endregion ----adminsPanelLang
            // $GLOBALS[''] = new ("");
        
        }
        

        function TestLanguage(){
            
            $GLOBALS['extraInfo'] = new DisplayingText("Test language added", "");
            $GLOBALS['defaultMessage'] = new DisplayingText("Test language added", "");
            $GLOBALS['navLang'] = new NavLang("Test language added", "Test language added");
            $GLOBALS['requestTab'] = new RequestTab("Test language added", "Test language added", "Test language added", "Test language added", "Test language added", "Test language added");
            $GLOBALS['Thead'] = new Create_th("Test language added", "Test language added", "Test language added", "Test language added", "Test language added", "Test language added", "Test language added"); 
            $GLOBALS['loggedInMessage'] = new LogedInMessage("Test language added");
            $GLOBALS['submitedTable'] = new UsersSubmitionOnHoldHeaderMessage("Test language added");
            $GLOBALS['Submit'] = new Submit("Test language added");
            // $GLOBALS[''] = new ("");
        
        }

        

        
}


$languages = new Languages(['English' => '1', 'Hebrew' => '2', 'Finnish' => '3','TestLanguage' => '4']);
//For adding languages you need to add it to this array and add function with same name into the Languages class.


#endregion ----App's workers panel language creation
?>