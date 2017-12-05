<!DOCTYPE html>
<html>
    <head>
        <title>List Series</title>
    </head>
    <body>
        <h2>Available series</h2>
        <?php
        session_start();
        if ( empty($_REQUEST['patient_number']) ) {
            echo("<p>No patient ID was given!</p>");
            exit();
        } else {
            $patient_number = $_REQUEST['patient_number'];
            $connection = require_once('db.php');
            
            $stmt = $connection->prepare("SELECT request_number, description FROM Study WHERE request_number IN (SELECT number FROM Request WHERE patient_id=:pat_id) ORDER BY date DESC LIMIT 2");
            $stmt->bindParam(':pat_id', $patient_number);
            if ( !$stmt->execute() ) {
                echo("<p>An error occurred!</p>");                    
                exit();
            }    
            if ( $stmt->rowCount() == 0) {
                echo("<p>No studies are available to this patient!</p>");
                $connection = NULL;
                exit();            
            } else {
                // studies available
                $last_study_1 = $stmt->fetch();
                $last_study_2 = $stmt->fetch(); //This one might not exist
                $_SESSION['last_study_1'] = $last_study_1;
                $_SESSION['last_study_2'] = $last_study_2;
                $req_num = $last_study_1['request_number'];
                $desc = $last_study_1['description'];
                $stmtSeries = $connection->prepare("SELECT series_id, name FROM Series WHERE request_number=:req_num AND description=:desc");
                $stmtSeries->bindParam(':req_num', $req_num);
                $stmtSeries->bindParam(':desc', $desc);
                if ( !$stmtSeries->execute() ) {
                    echo("<p>An error occurred!</p>");                    
                    $connection = NULL;
                    exit();
                }
                if ($stmtSeries->rowCount() > 0 ) {
                    echo("<table border=1 cellpadding='5'>");
                    echo("<thead><tr><th>Series ID</th><th>Series Name</th><th></th></tr></thead>");
                    foreach ($stmtSeries as $row) {
                        echo("<tr><td>".$row['series_id']."</td>");
                        echo("<td>".$row['name']."</td>");
                        echo("<td><form action='new_region.php' method ='post'>");
                        echo("<input type='hidden' name='series_id' value='".$row['series_id']."'/>");   
                        echo("<input type='submit' value='Next'/>");
                        echo("</form></td></tr>");    
                    }
                    echo("</table>");        
                }else{
                    //no series available
                    echo("<p>No series are available to this patient's last study!</p>");
                    $connection = NULL;
                    exit();
                }
            }
            $connection = NULL;
        }
        ?>
    </body>
</html>