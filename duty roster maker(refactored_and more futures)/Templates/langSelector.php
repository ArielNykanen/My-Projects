<div id="langChangeDiv"> 
    
<form method="GET">
        <div>
            <select id='langChange' name="langSelection" onchange="this.form.submit()">
                    <?php  echo $languages->setLang(); ?>   
            </select>
        </div>
        </form>
    </div>

    