<!DOCTYPE html>
<html>
    <body>
        <h3>Add a new patient</h3>
        <form action="insert_patient.php" method="post">
            <table>
                <tr>
                    <td align='right'>Number (ID):</td>
                    <td><input type="text" name="new_patient_number"></td>
                </tr>
                <tr>
                    <td align='right'>Name:</td>
                    <td><input type="text" name="new_patient_name"></td>
                </tr>                
                <tr>
                    <td align='right'>Birthday:</td>
                    <td><input type="date" name="new_patient_birthday"></td>
                </tr>
                <tr>
                    <td align='right'>Address:</td>
                    <td><input type="text" name="new_patient_address"></td>
                </tr>
            </table>
            <p><input type="submit" value="Submit"></p>
        </form>
    </body>
</html>