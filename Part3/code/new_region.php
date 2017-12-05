<!DOCTYPE html>
<html>
    <head>
        <title>Add a new region</title>
    </head>
    <body>
        <h2>Add a new region</h2>
<?php
    if ( empty($_REQUEST['series_id']) ) {
        echo("<p>No information [series id] was given!</p>");
        exit();
    }
    else {
        $series_id = $_REQUEST['series_id'];
        $connection = require_once('db.php');
        $stmt = $connection->prepare("SELECT element_index FROM Element WHERE series_id=:series_id");
        $stmt->bindParam(':series_id', $series_id);
        if ( !$stmt->execute() ) {
            echo("<p>An error occurred!</p>");                    
            exit();
        }
        if ($stmt->rowCount() > 0 ) {
            //elements available
            $elements = [];
            foreach ($stmt as $row) {
                array_push($elements, $row);
            }
        } else {
            echo("<p>No elements are available for this series! :(</p>");
            $connection = NULL;
            exit();
        }
        $connection = NULL;
    }
?>
        <form action="add_region.php" method="post">
            <fieldset style="display: inline-block">
                <legend>Region:</legend>
                    <table>
                        <tr>
                            <td align='right'>Series:</td>
                            <td>
                                <input type='hidden' name='series_id' value='<?=$series_id?>'><?=$series_id?>
                            </td>
                        </tr>
                        <tr>
                            <td align='right'>Element:</td>
                            <td>
                                <select name="element">
                                    <?php
                                        foreach( $elements as $element) {
                                            echo("<option value='".$element['element_index']."'>".$element['element_index']."</option>" );
                                        }
                                    ?>
                                </select>
                            </td>
                        </tr>                
                        <tr>
                            <td align='right'>X1:</td>
                            <td><input type="number" step="any" name="x1"></td>
                        </tr>
                        <tr>
                            <td align='right'>X2:</td>
                            <td><input type="number" step="any" name="x2"></td>
                        </tr>
                        <tr>
                            <td align='right'>Y1:</td>
                            <td><input type="number" step="any" name="y1"></td>
                        </tr>
                        <tr>
                            <td align='right'>Y2:</td>
                            <td><input type="number" step="any" name="y2"></td>
                        </tr>
                    </table>
                    <p><input type="submit" value="Add region"></p>
                </fieldset>
        </form>
    </body>
</html>