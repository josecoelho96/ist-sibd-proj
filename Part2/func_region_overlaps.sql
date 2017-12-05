DROP FUNCTION IF EXISTS region_overlaps_element;
DELIMITER $$

CREATE FUNCTION region_overlaps_element(series_id INTEGER, elem_index INTEGER, x1 FLOAT, y1 FLOAT, x2 FLOAT, y2 FLOAT)
  RETURNS BOOLEAN
  BEGIN
    DECLARE result BOOLEAN;
    DECLARE Xmin FLOAT;
    DECLARE Xmax FLOAT;
    DECLARE Ymin FLOAT;
    DECLARE Ymax FLOAT;

    IF x1 > x2
    THEN
      SET Xmin = x2;
      SET Xmax = x1;
    ELSE
      SET Xmin = x1;
      SET Xmax = x2;
    END IF;

    IF y1 > y2
    THEN
      SET Ymin = y2;
      SET Ymax = y1;
    ELSE
      SET Ymin = y1;
      SET Ymax = y2;
    END IF;

    IF EXISTS(SELECT *
              FROM Region AS r
              WHERE series_id = r.series_id
                    AND elem_index = r.elem_index
                    AND NOT ((r.x1 < Xmin AND r.x2 < Xmin)
                             OR (r.x1 > Xmax AND r.x2 > Xmax)
                             OR (r.y1 < Ymin AND r.y2 < Ymin)
                             OR (r.y1 > Ymax AND r.y2 > Ymax)))

    THEN
      SET result = TRUE;
    ELSE
      SET result = FALSE;
    END IF;
    RETURN result;
  END $$

DELIMITER ;