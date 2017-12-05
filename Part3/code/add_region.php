<!DOCTYPE html>
<html>
    <head>
        <title>Add a new region</title>
    </head>
    <body>
    <h2>Add a new region</h2>
<?php
    session_start();
    if ( empty($_REQUEST['series_id']) || empty($_REQUEST['element']) || empty($_SESSION['last_study_1']) ) {
        echo("<p>Can't create a new region!</p>");
        echo("<p>Insuficient information given!</p>");
        exit();
    } else {
        $series_id = $_REQUEST['series_id'];
        $element = $_REQUEST['element'];
        $x1 = $_REQUEST['x1'];
        $x2 = $_REQUEST['x2'];
        $y1 = $_REQUEST['y1'];
        $y2 = $_REQUEST['y2'];
        $connection = require_once('db.php');
        $stmt = $connection->prepare("INSERT INTO Region VALUES (:series_id, :element, :x1, :y1, :x2, :y2)");
        $stmt->bindParam(':series_id', $series_id);
        $stmt->bindParam(':element', $element);
        $stmt->bindParam(':x1', $x1);
        $stmt->bindParam(':y1', $y1);
        $stmt->bindParam(':x2', $x2);
        $stmt->bindParam(':y2', $y2);

        if ( !$stmt->execute() ) {
            echo("<p>An error occurred!</p>");                    
            $connection = NULL;
            exit();
        }        
        // get the other study (if exists) by session variables
        if ( !empty($_SESSION['last_study_2']) ) {
            // second study exists
            $last_study_2_req_num = $_SESSION['last_study_2']['request_number'];
            $last_study_2_desc =  $_SESSION['last_study_2']['description'];
            // get all series from this study
            $stmtSeries = $connection->prepare("SELECT series_id FROM Series WHERE request_number=:req_num AND description=:desc");
            $stmtSeries->bindParam(':req_num', $last_study_2_req_num);
            $stmtSeries->bindParam(':desc', $last_study_2_desc);
            if ( !$stmtSeries->execute() ) {
                echo("<p>An error occurred!</p>");                    
                $connection = NULL;
                exit();
            }

            if ( $stmtSeries->rowCount() > 0 ) {
                // series related to the 2nd study exists
                $series_list = [];
                foreach ($stmtSeries as $row) {
                    array_push($series_list, $row['series_id']);                    
                }
                // get all elements from all series
                $stmtElements = $connection->prepare("SELECT series_id, element_index FROM Element WHERE series_id IN (".implode(', ',$series_list).")");        
                if ( !$stmtElements->execute() ) {
                    echo("<p>An error occurred!</p>");                    
                    $connection = NULL;
                    exit();
                }
                if ( $stmtElements->rowCount() > 0 ) {
                    // list all elements!
                    echo("<h3>List of all elements of the patient last study</h3>");
                    echo("<table border=1 cellpadding='5'>");
                    echo("<thead><tr><th>Series ID</th><th>Element Index</th><th>Overlaps?</th></tr></thead>");
                    $stmtOverlap = $connection->prepare("SELECT region_overlaps_element(:series_id, :element, :x1, :y1, :x2, :y2)");
                    $new_clinical_evidence = 0;
                    foreach ( $stmtElements as $element ) {
                        if ( !$stmtOverlap->execute( [ ':x1'=>$x1, ':x2'=>$x2, ':y1'=>$y1, ':y2'=>$y2, 
                        ':series_id'=>$element['series_id'], ':element'=>$element['element_index'] ] ) )  {
                            echo("<p>An error occurred!</p>");                    
                            $connection = NULL;
                            exit();
                        }                        
                        $result = $stmtOverlap->fetch();
                        if ($result[0]) {
                            $new_clinical_evidence = 1;
                        }
                        echo("<tr><td>".$element['series_id']."</td>");
                        echo("<td>".$element['element_index']."</td>");
                        echo("<td>".($result[0] ? 'Yes': 'No')."</td></tr>");                        
                    }
                    echo("</table>");
                    if ($new_clinical_evidence ) {
                        echo("<h2>NEW CLINICAL EVIDENCE FOUND!</h2>");
                    }
                } else {
                    echo("<p>No elements in the series of the second study!</p>");
                }
                // got all elements, call for overlaps function
            } else {
                // no series exist for the second study
                echo("<p>No series for second study!</p>");
            }
        } else {
            // second study doesn't exist!
            echo("<p>No second study!</p>");
        }
        unset($_REQUEST);
    }
?>
</body>
</html>