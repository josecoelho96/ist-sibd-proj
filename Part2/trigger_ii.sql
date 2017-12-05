/* Triggers */
/*
Write triggers to:
ii) prevent someone from trying to associate a device to a patient in overlapping
periods. Additionally, fire an error message with text “Overlapping	Periods” when this event occurs.
*/

/* on create */
DROP TRIGGER IF EXISTS check_overlaps_create;

DELIMITER $$
CREATE TRIGGER check_overlaps_create
BEFORE INSERT ON Wears
FOR EACH ROW
  BEGIN
    IF (SELECT EXISTS(SELECT *
                      FROM Wears AS w
                      WHERE w.manuf = NEW.manuf
                            AND w.snum = NEW.snum
                            AND NOT (NEW.start < w.start AND NEW.end < w.start
                                     OR NEW.start > w.end AND NEW.end > w.end)))
    THEN
      CALL error('Overlapping Periods');
    END IF;

  END$$

DELIMITER ;

/* on update */
DROP TRIGGER IF EXISTS check_overlaps_update;

DELIMITER $$
CREATE TRIGGER check_overlaps_update
BEFORE UPDATE ON Wears
FOR EACH ROW
  BEGIN
    IF (SELECT EXISTS(SELECT *
                      FROM Wears AS w
                      WHERE w.snum = NEW.snum
                            AND w.manuf = NEW.manuf
                            AND w.start != OLD.start
                            AND w.end != OLD.end
                            AND NOT (NEW.start < w.start AND NEW.end < w.start
                                     OR NEW.start > w.end AND NEW.end > w.end)))
    THEN
      CALL error('Overlapping Periods');
    END IF;

  END$$

DELIMITER ;