<!DOCTYPE html>
<html>
    <head>
        <title>Patient details</title>
    </head>
    <body>
        <h2>Patient details</h2>
        <?php
            session_start();
            if (isset($_REQUEST['pat_id'])) {
                $patient_id = $_REQUEST['pat_id'];
                // Save patient id in a session variable
                $_SESSION['patient_id'] = $patient_id;
                $connection = require_once('db.php');
                $stmt = $connection->prepare("SELECT manuf, snum, start, end FROM Wears WHERE patient=:pat_id ORDER BY start DESC");
                $stmt->bindParam(':pat_id', $patient_id);
                if ($stmt->execute() ) {
                    if ($stmt->rowCount() > 0 ) {
                        // Store all worn devices.
                        $notInUse = [];
                        echo("<h3>Currently worn devices:</h3>");
                        echo("<table border=1 cellpadding='5'>");
                        echo("<thead><tr><th>Manufacturer</th><th>Serial Number</th><th>Start</th><th>End</th><th>Replace</th></tr></thead>");
                        foreach ($stmt as $row) {
                            if (time() < strtotime($row['end']) and time() > strtotime($row['start'])) {
                                //currently using device
                                echo("<tr><td>".$row['manuf']."</td>");
                                echo("<td>".$row['snum']."</td>");
                                echo("<td>".$row['start']."</td>");
                                echo("<td>".$row['end']."</td>");
                                echo("<td><form action='available_devices.php' method ='post'>");
                                echo("<input type='hidden' name='manufacturer' value='".$row['manuf']."'/>");
                                echo("<input type='hidden' name='serialnumber' value='".$row['snum']."'/>");   
                                echo("<input type='hidden' name='time_start' value='".$row['start']."'/>");   
                                echo("<input type='hidden' name='time_end' value='".$row['end']."'/>");   
                                echo("<input type='submit' value='Replace'/>");
                                echo("</form></td></tr>");
                            } else {
                                //worn in the past, must be printed only after all others
                                array_push($notInUse, $row);
                            }
                        }
                        echo("</table>");        
                        echo("<h4>Device history:</h4>");
                        // print all worn devices
                        echo("<table border=1 cellpadding='5'>");
                        echo("<thead><tr><th>Manufacturer</th><th>Serial Number</th><th>Start</th><th>End</th></tr></thead>");
                        foreach ($notInUse as $row) {
                            echo("<tr><td>".$row['manuf']."</td><td>".$row['snum']."</td><td>".$row['start']."</td><td>".$row['end']."</td></tr>");
                        }
                        echo("</table>");
                    } else {
                        echo("<p>The patient doesn't wear or worn any devices!</p>");    
                    }
                } else {
                    echo("<p>An error occurred!</p>");      
                    exit();
                }
                // close connection
                $connection = NULL;
            } else {
                echo("<p>No patient ID was given!</p>");
            }
        ?>
    </body>
</html>
