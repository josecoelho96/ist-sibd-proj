<!DOCTYPE html>
<html>
    <head>
        <title>Device replacement</title>
    </head>
    <body>
        <h2>Device replacement</h2>
        <?php
            session_start();
            if (isset($_REQUEST['manufacturer'], $_REQUEST['serialnumber'], $_REQUEST['time_start'], $_REQUEST['time_end'])) {
                $manufacturer = $_REQUEST['manufacturer'];
                // save some info in session variables
                $_SESSION['manufacturer'] = $manufacturer;
                $_SESSION['old_snum'] = $_REQUEST['serialnumber'];
                $_SESSION['time_start'] = $_REQUEST['time_start'];
                $_SESSION['time_end'] = $_REQUEST['time_end'];
                $connection = require_once('db.php');
                $stmt = $connection->prepare('SELECT serialnum, model FROM Device WHERE manufacturer = :manuf AND serialnum NOT IN(SELECT snum FROM Wears WHERE Wears.manuf = :manuf AND NOW() BETWEEN Wears.start AND Wears.end)');
                $stmt->bindParam(':manuf', $manufacturer);                
                if ($stmt->execute() ) {
                    if ($stmt->rowCount() > 0) {
                        //List all alternatives
                        echo("<h3>Devices available:</h3>");
                        echo("<table border=1 cellpadding='5'>");
                        echo("<thead><tr><th>Manufacturer</th><th>Serial Number</th><th>Model</th><th>Replace</th></tr></thead>");
                        foreach ($stmt as $row) {
                            echo("<tr><td>".$manufacturer."</td>");
                            echo("<td>".$row['serialnum']."</td>");
                            echo("<td>".$row['model']."</td>");
                            echo("<td><form action='replace_device.php' method ='post'>");
                            echo("<input type='hidden' name='new_snum' value='".$row['serialnum']."'/>");
                            echo("<input type='submit' value='Replace'/>");
                            echo("</form></td></tr>");
                        }
                        echo("</table>");    
                    } else {
                        // No alternatives available!
                        echo("<p>There isn't any device available!</p>");                            
                    }                
                } else {
                    echo("<p>An error occurred!</p>");                    
                    exit();
                }
            } else {
                echo("<p>No information [manufacturer] was given!</p>");
            }
        ?>
    </body>
</html>