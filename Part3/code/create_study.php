<!DOCTYPE html>
<html>
    <head>
        <title>Study creation</title>
    </head>
    <body>
        <h2>Creation of a new study</h2>
        <h3>Results</h3>
<?php
    if ( empty($_REQUEST['request_id']) || empty($_REQUEST['description']) || empty($_REQUEST['doctor_id']) || empty($_REQUEST['date']) || empty($_REQUEST['device']) || empty($_REQUEST['series_id']) || empty($_REQUEST['series_name']) ) {
        echo("<p>ERROR: Insuficient information provided!</p>");
        exit();        
    } else {
        $description = $_REQUEST['description'];
        $doctor_id = $_REQUEST['doctor_id'];
        $date = $_REQUEST['date'];
        $device = json_decode($_REQUEST['device'], true);
        $series_id = $_REQUEST['series_id'];
        $series_name = $_REQUEST['series_name'];
        $request_id = $_REQUEST['request_id'];
        $connection=require_once('db.php');
        $connection->beginTransaction();
        $stmtStudy = $connection->prepare("INSERT INTO Study VALUES(:req_num, :desc, :date, :doctor_id, :manuf, :snum)");
        $stmtStudy->bindParam(':req_num', $request_id);
        $stmtStudy->bindParam(':desc', $description);
        $stmtStudy->bindParam(':date', $date);
        $stmtStudy->bindParam(':doctor_id', $doctor_id);
        $stmtStudy->bindParam(':manuf', $device['manufacturer']);
        $stmtStudy->bindParam(':snum', $device['serialnum']);
        if ( !$stmtStudy->execute() ) {
            echo("<p>An error occurred!</p>");
            echo("<p>Study not created!</p>");
            $connection->rollback();
            $connection = NULL;
            exit();
        }
        $base_url = "http://web.tecnico.ulisboa.pt/~ist181013/series/".$series_id;
        $stmtSeries = $connection->prepare("INSERT INTO Series VALUES(:series_id, :series_name, :base_url, :req_num, :desc)");
        $stmtSeries->bindParam(':series_id', $series_id);
        $stmtSeries->bindParam(':series_name', $series_name);
        $stmtSeries->bindParam(':base_url', $base_url);
        $stmtSeries->bindParam(':req_num', $request_id);
        $stmtSeries->bindParam(':desc', $description);
        
        if ( !$stmtSeries->execute() ) {
            echo("<p>An error occurred!</p>");       
            echo("<p>Study not created!</p>");            
            $connection->rollback();
            $connection = NULL;
            exit();
        }
        $connection->commit();  
        unset($_REQUEST);
        $connection = NULL;
        echo("<p>Study created!</p>");
    }
?>
</body>
</html>