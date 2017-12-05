<!DOCTYPE html>
<html>
    <head>
        <title>Adding a new patient</title>
    </head>
    <body>
        <h2>Adding a new patient</h2>
        <?php
            if ( empty($_REQUEST['new_patient_name']) || empty($_REQUEST['new_patient_number']) || empty($_REQUEST['new_patient_birthday']) || empty($_REQUEST['new_patient_address']) ) {
                // Invalid request / user directly opened file.
                echo("<p>ERROR: Patient info must be provided on the request!</p>");
            } else {
                // Request with all required parameters was made
                $new_patient_number = $_REQUEST['new_patient_number'];
                $new_patient_name = $_REQUEST['new_patient_name'];
                $new_patient_birthday = $_REQUEST['new_patient_birthday'];
                $new_patient_address = $_REQUEST['new_patient_address'];
                $connection = require_once('db.php');
                $stmt = $connection->prepare("INSERT INTO Patient VALUES(:id, :name, :birthday, :address)");
                $stmt->bindParam(':id', $new_patient_number);
                $stmt->bindParam(':name', $new_patient_name);
                $stmt->bindParam(':birthday', $new_patient_birthday);
                $stmt->bindParam(':address', $new_patient_address);

                if ( $stmt->execute() ) {
                    // Patient added                 
                    echo("<p>SUCCESS: Patient added successfully!</p>");
                    echo("<p>Patient info:</p>");
                    echo("<table border=1>");
                    echo("<tr><td align='right'>Number (ID):</td><td>$new_patient_number</td></tr>");
                    echo("<tr><td align='right'>Name:</td><td>$new_patient_name</td></tr>");
                    echo("<tr><td align='right'>Birthday:</td><td>$new_patient_birthday</td></tr>");
                    echo("<tr><td align='right'>Address:</td><td>$new_patient_address</td></tr>");
                    echo("</table>");                    
                } else {
                    // Failed to insert a patient
                    echo("<p>An error occurred! The patient was not added!</p>");
                }
                // Close connection
                $connection = NULL;
            }
        ?>
    </body>
</html>