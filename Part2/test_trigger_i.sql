/* Creating situations to test trigger i */

/* Test Insert */
/* Valid */
INSERT INTO Study VALUES (5, 'Exame ao pé esquerdo 1', '2017-11-13', 2, 'Medtronic', 80558661);
INSERT INTO Study VALUES (5, 'Exame ao pé esquerdo 2', '2017-11-13', 3, 'Medtronic', 80558661);
INSERT INTO Study VALUES (5, 'Exame ao pé esquerdo 3', '2017-11-13', 4, 'Medtronic', 80558661);
INSERT INTO Study VALUES (5, 'Exame ao pé esquerdo 4', '2017-11-13', 5, 'Medtronic', 80558661);
/* Invalid */
INSERT INTO Study VALUES (5, 'Exame ao pé esquerdo 5', '2017-11-13', 1, 'Medtronic', 80558661);
/* Valid */
INSERT INTO Study VALUES (9, 'Radiografia braço direito 1', '2017-11-13', 1, 'Medtronic', 80558661);
INSERT INTO Study VALUES (9, 'Radiografia braço direito 2', '2017-11-13', 2, 'Medtronic', 80558661);
INSERT INTO Study VALUES (9, 'Radiografia braço direito 3', '2017-11-13', 4, 'Medtronic', 80558661);
INSERT INTO Study VALUES (9, 'Radiografia braço direito 4', '2017-11-13', 5, 'Medtronic', 80558661);
/* Invalid */
INSERT INTO Study VALUES (9, 'Radiografia braço direito 5', '2017-11-13', 3, 'Medtronic', 80558661);

/* Test Update */
/* Valid */
UPDATE Study SET doctor_id = 3 WHERE request_number = 5 AND description = 'Exame ao pé esquerdo 1';
UPDATE Study SET doctor_id = 4 WHERE request_number = 5 AND description = 'Exame ao pé esquerdo 2';
UPDATE Study SET doctor_id = 5 WHERE request_number = 5 AND description = 'Exame ao pé esquerdo 3';

/* Invalid */
UPDATE Study SET doctor_id = 1 WHERE request_number = 5 AND description = 'Exame ao pé esquerdo 4';

/* Valid */
UPDATE Study SET doctor_id = 2 WHERE request_number = 9 AND description = 'Radiografia braço direito 1';
UPDATE Study SET doctor_id = 1 WHERE request_number = 9 AND description = 'Radiografia braço direito 2';
UPDATE Study SET doctor_id = 5 WHERE request_number = 9 AND description = 'Radiografia braço direito 3';

/* Invalid */
UPDATE Study SET doctor_id = 3 WHERE request_number = 9 AND description = 'Radiografia braço direito 4';