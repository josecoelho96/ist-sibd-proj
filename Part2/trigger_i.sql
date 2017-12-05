/* Triggers */
/*
Write triggers to:
i) ensure that a doctor who prescribes an exam may not perform that same exam
*/

/* On create */
DROP TRIGGER IF EXISTS doctor_check_create;

DELIMITER $$
CREATE TRIGGER doctor_check_create
BEFORE INSERT ON Study
FOR EACH ROW
  BEGIN
    IF (SELECT EXISTS(SELECT *
                      FROM Request, Study
                      WHERE Request.number = Study.request_number
                            AND new.doctor_id = Request.doctor_id
                            AND new.request_number = Study.request_number))
    THEN
      CALL ERROR('Error: The same doctor who prescribed the exam is performing a study.');
    END IF;
  END$$

DELIMITER ;

/* On update */
DROP TRIGGER IF EXISTS doctor_check_update;

DELIMITER $$
CREATE TRIGGER doctor_check_update
BEFORE UPDATE ON Study
FOR EACH ROW
  BEGIN
    IF (SELECT EXISTS(SELECT *
                      FROM Request, Study
                      WHERE Request.number = Study.request_number
                            AND NEW.doctor_id = Request.doctor_id
                            AND NEW.request_number = Study.request_number))
    THEN
      CALL ERROR('Error: The same doctor who prescribed the exam is performing a study.');
    END IF;
  END$$

DELIMITER ;