<!DOCTYPE html>
<html>
    <head>
        <title>Add a study</title>
    </head>
    <body>
<?php
    if (empty ($_REQUEST['request_id']) ) {
        echo("<p>ERROR: A request id must be provided!</p>");
        exit();
    } else {
        $request_id = $_REQUEST['request_id'];
        $connection = require_once('db.php');
        $stmt = $connection->prepare("SELECT doctor_id FROM Doctor WHERE doctor_id NOT IN (SELECT doctor_id FROM Request WHERE number=:req_num) ORDER BY doctor_id");
        $stmt->bindParam(':req_num', $request_id);
        if ( !$stmt->execute() ) {
            echo("<p>An error occurred!</p>");                    
            exit();
        }
        $available_doctors = [];
        foreach($stmt as $row) {
            array_push($available_doctors, $row['doctor_id']);
        }
        $stmt = $connection->prepare("SELECT serialnum, manufacturer FROM Device ORDER BY manufacturer");
        if ( !$stmt->execute() ) {
            echo("<p>An error occurred!</p>");                    
            exit();
        }        
        $available_devices = [];
        foreach($stmt as $row) {
            array_push($available_devices, array('manufacturer'=>$row["manufacturer"], 'serialnum'=>$row['serialnum']));
        }
        $connection = NULL;
    }
?>
        <h2>Add a new study on request <?=$_REQUEST['request_id']?></h2>
        <form action="create_study.php" method="post">
            <fieldset style="display: inline-block">
                <legend>Study info:</legend>
                    <table>
                        <tr>
                            <td align='right'>Request number:</td>
                            <td>
                                <?=$_REQUEST['request_id']?>
                                <input type='hidden' name='request_id' value='<?=$_REQUEST['request_id']?>'>
                            </td>
                        </tr>
                        <tr>
                            <td align='right'>Description:</td>
                            <td><input type="text" name="description"></td>
                        </tr>                
                        <tr>
                            <td align='right'>Doctor ID:</td>
                            <td>
                                <select name="doctor_id">
                                    <?php
                                        foreach( $available_doctors as $doctor) {
                                            echo("<option value=".$doctor.">$doctor</option>");
                                        }
                                    ?>
                                </select>
                            </td>
                        </tr>
                        <tr>
                            <td align='right'>Date:</td>
                            <td><input type="date" name="date"></td>
                        </tr>
                        <tr>
                            <td align='right'>Device:</td>
                            <td>
                                <select name="device">
                                    <?php
                                        foreach( $available_devices as $device) {
                                            $strjson = "value='".json_encode($device)."'";
                                            echo("<option ".$strjson.">".$device['manufacturer']." : ".$device['serialnum']."</option>" );
                                        }
                                    ?>
                                </select>
                            </td>
                        </tr>
                    </table>
                </fieldset>
                <br>
                <fieldset style="display: inline-block">
                <legend>Series info:</legend>
                    <table>
                        <tr>
                            <td align='right'>Series id:</td>
                            <td><input type="number" name="series_id"></td>
                        </tr>
                        <tr>
                            <td align='right'>Series name:</td>
                            <td><input type="text" name="series_name"></td>
                        </tr>                
                    </table>
                </fieldset>            
            <p><input type="submit" value="Next"></p>
        </form>
    </body>
</html>