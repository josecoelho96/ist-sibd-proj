/* Query 2 */
/* Write a query to retrieve the name(s) of the patient(s) 
who have been subject of studies with all devices of 
manufacturer “Medtronic” in the past calendar year. 

VV 

Patients who have been subject of studies with all devices
of the manufacturer "Medtronic" in the past calendar year.

VV

Patients for which there is no device of the 
manufacturer "Medtronic" which was not used to perform a study
in the past calendar year.

VV

Who are the patients for which there is no device of 
the manufacturer "Medtronic" which is not in the set of devices 
used to do a study in the past calendar year.
*/

SELECT name
FROM Patient AS p
WHERE NOT EXISTS(
    SELECT serialnum
    FROM Device AS d
    WHERE manufacturer = 'Medtronic'
          AND serialnum NOT IN (
      SELECT serial_number
      FROM Study AS s, Request AS r, Patient AS p2
      WHERE s.request_number = r.number
            AND p2.number = r.patient_id
            AND p2.name = p.name
            AND YEAR(s.date) = YEAR(CURRENT_DATE()) - 1));