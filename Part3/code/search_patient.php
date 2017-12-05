<!DOCTYPE html>
<html>
    <head>
        <title>Patient search results</title>
    </head>
    <body>
        <h2>Search results</h2>
        <?php        
        $patient_name = (empty($_REQUEST['patient_name']) ? '' : $_REQUEST['patient_name']);
        $connection = require_once('db.php');
        $stmt = $connection->prepare("SELECT number, name FROM Patient WHERE name LIKE :pat_name");
        echo("<h4>Results for: $patient_name </h4>");
        $patient_name = '%'.$patient_name.'%';
        $stmt->bindParam(':pat_name', $patient_name);
        if ( !$stmt->execute() ) {
            echo("<p>An error occurred!</p>");
            exit();
        }
        if ($stmt->rowCount() > 0 ) {
            echo("<table border=1 cellpadding='5'>");
            echo("<thead><tr><th>Name</th><th>Studies</th><th>Regions</th></tr></thead>");
            foreach($stmt as $patient) {
                echo("<tr><td><a href='patient_details.php?pat_id=".$patient['number']."'>".$patient['name']."</a></td>");
                echo("<td><form action='list_requests.php' method ='post'>");
                echo("<input type='hidden' name='patient_id' value='".$patient['number']."'/>");
                echo("<input type='submit' value='Add study'/>");
                echo("</form></td>");
                echo("<td><form action='list_series.php' method ='post'>");
                echo("<input type='hidden' name='patient_number' value='".$patient['number']."'/>");
                echo("<input type='submit' value='Add region'/>");
                echo("</form></td></tr>");
            }
            echo("</table>");
        } else {
            echo("<p>No patient was found!</p>");
            include('new_patient.php');
        }
        $connection = NULL;
        ?>
    </body>
</html>