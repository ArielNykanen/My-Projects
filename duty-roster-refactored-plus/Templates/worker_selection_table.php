<table>
<thead>
    <th>
    Sunday
    </th>
    <th>
    Monday
    </th>
    <th>
    Tuesday
    </th>
    <th>
    Wednesday
    </th>
    <th>
    Thursday
    </th>
    <th>
    Friday
    </th>
    <th>
    Saturday
    </th>
</thead>

<tbody >
    <?php 

    for ($i=0; $i <= 5; $i++) { 
        echo "<td>
        <select class='sellectPre form-control selcls' name=\"sellectPre[]\" id=\"\">
            <option value=\"1\">
                Morning
            </option>
            "; if($i !== 5){
                echo  "
            <option value=\"2\">
                Eavning
            </option>
            <option value=\"3\">
            Both
            </option>
            <option value=\"0\">
            Freeday
            </option>";
        }else{
            echo "
            <option value=\"0\">
            Freeday
            </option>";
        }
        echo"
        </select>
        </td>";
    }
    
    ?>