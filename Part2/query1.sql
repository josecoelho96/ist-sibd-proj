/* Query 1 */
/* Write a query to retrieve the name(s) of the patient(s) 
with the highest number of readings of units of 
“LDL cholesterol in mg/dL” above 200 in the past 90 days. */
SELECT name
FROM Patient
WHERE number IN (
  SELECT patient
  FROM Sensor AS s1, Reading AS r1, Wears AS w1
  WHERE r1.snum = s1.snum
        AND r1.manuf = s1.manuf
        AND r1.snum = w1.snum
        AND r1.manuf = w1.manuf
        AND r1.datetime BETWEEN w1.start AND w1.end
        AND units = 'LDL cholesterol in mg/dL'
        AND DATEDIFF(current_date, r1.datetime) < 90
        AND r1.value > 200
  GROUP BY patient
  HAVING COUNT(patient) >= ALL (
    SELECT COUNT(patient)
    FROM Sensor AS s, Reading AS r, Wears AS w
    WHERE r.snum = s.snum
          AND r.manuf = s.manuf
          AND r.snum = w.snum
          AND r.manuf = w.manuf
          AND r.datetime BETWEEN w.start AND w.end
          AND units = 'LDL cholesterol in mg/dL'
          AND DATEDIFF(current_date, r.datetime) < 90
          AND r.value > 200
    GROUP BY patient));


/* 
****** RESULTS ******
+-------------------+
| name              |
+-------------------+
| Angelini Picanço  |
+-------------------+
*/
