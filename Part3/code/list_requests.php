<!DOCTYPE html>
<html>
    <head>
        <title>List requests</title>
    </head>
    <body>
        <h2>Available requests</h2>
        <?php
            if(isset($_REQUEST['patient_id'])){
                $patient_id = $_REQUEST['patient_id'];
                $connection = require_once('db.php');
                $stmt = $connection->prepare("SELECT number FROM Request WHERE patient_id = :patient_id ORDER BY number");
                $stmt->bindParam(':patient_id', $patient_id);
                if ( !$stmt->execute() ) {
                    echo("<p>An error occurred!</p>");
                    exit();
                }
                if ($stmt->rowCount() > 0 ) {
                    echo("<table border=1 cellpadding='5'>");
                    echo("<thead><tr><th>Request</th><th></th></tr></thead>");
                    foreach ($stmt as $row) {
                        echo("<tr><td>Request ".$row['number']."</td>");
                        echo("<td><form action='new_study.php' method ='post'>");
                        echo("<input type='hidden' name='request_id' value='".$row['number']."'/>");   
                        echo("<input type='submit' value='Select'/>");
                        echo("</form></td></tr>");    
                    }
                    echo("</table>");                    
                } else {
                    echo("<p>No requests are available!</p>");
                }
                $connection = NULL;
            }
            else{
                echo("<h1>No Patient was specified</h1>");
            }
        ?>
    </body>
</html>