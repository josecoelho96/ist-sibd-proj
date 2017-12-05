<!DOCTYPE html>
<html>
    <head>
        <title>Device replacement</title>
    </head>
    <body>
        <h2>Device replacement</h2>
        <?php
            session_start();
            if (isset($_SESSION['patient_id'], $_SESSION['manufacturer'], $_SESSION['time_start'], $_SESSION['time_end'], $_SESSION['old_snum'], $_REQUEST['new_snum']) ) {
                $patient = $_SESSION['patient_id'];
                $manufacturer = $_SESSION['manufacturer'];
                $old_serialnum = $_SESSION['old_snum'];
                $new_serialnum = $_REQUEST['new_snum'];
                $start_time = $_SESSION['time_start'];
                $end_time = $_SESSION['time_end'];
                $connection = require_once('db.php');
                $current_time = date('Y-m-d H:i:s');
                $connection->beginTransaction();
                $stmtPeriod = $connection->prepare("INSERT INTO Period VALUES(:start, :end)");
                // Create a new period (start_time, current_time)
                if ( !$stmtPeriod->execute([':start' => $start_time, ':end' => $current_time]) ) {
                    echo("<p>An error occurred!</p>");                
                    $connection->rollback();
                    $connection = NULL;
                    exit();
                }
                // Create a new period (current_time, end_time)
                if ( !$stmtPeriod->execute([':start' => $current_time, ':end' => $end_time]) ) {
                    echo("<p>An error occurred!</p>");                    
                    $connection->rollback();
                    $connection = NULL;
                    exit();
                }
                // Update entry
                $stmtUpdate = $connection->prepare("UPDATE Wears SET end = :current_time WHERE Wears.end = :end AND Wears.start = :start AND patient = :pat_id");
                $stmtUpdate->bindParam(':current_time', $current_time);
                $stmtUpdate->bindParam(':end', $end_time);
                $stmtUpdate->bindParam(':start', $start_time);
                $stmtUpdate->bindParam(':pat_id', $patient);
                if ( !$stmtUpdate->execute() ) {
                    echo("<p>An error occurred!</p>");                    
                    $connection->rollback();
                    $connection = NULL;
                    exit();
                }
                // create a new wear entry
                $stmtInsert = $connection->prepare("INSERT INTO Wears VALUES (:start, :end, :patient, :snum, :manuf)");
                $stmtInsert->bindParam(':start', $current_time);
                $stmtInsert->bindParam(':end', $end_time);
                $stmtInsert->bindParam(':patient', $patient);
                $stmtInsert->bindParam(':snum', $new_serialnum);
                $stmtInsert->bindParam(':manuf', $manufacturer);
                if ( !$stmtInsert->execute() ) {
                    echo("<p>An error occurred!</p>");                    
                    $connection->rollback();
                    $connection = NULL;            
                    exit();
                }
                $connection->commit();  
                // unset session variables
                session_unset();
                $connection = NULL;
                echo("<p>Device changed!</p>");
            } else {
                echo("<p>No information [patient, manufacturer, serial number, time] was received!</p>");
            }
        ?>
    </body>
</html>