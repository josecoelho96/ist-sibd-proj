/* Create a set of regions to allow tests on the function created */
/* The regions will belong to the element 3 of the series 9 */

INSERT INTO Element VALUES (9, 3);

/* Region -> X1, Y1, X2, Y2 */
/* Region A */
INSERT INTO Region VALUES (9, 3, 0.10, 0.70, 0.30, 0.90);
/* Region B */
INSERT INTO Region VALUES (9, 3, 0.60, 0.70, 0.80, 0.90);
/* Region C */
INSERT INTO Region VALUES (9, 3, 0.10, 0.10, 0.30, 0.30);
/* Region D */
INSERT INTO Region VALUES (9, 3, 0.15, 0.15, 0.20, 0.20);
/* Region E */
INSERT INTO Region VALUES (9, 3, 0.25, 0.25, 0.50, 0.050);


/* 0: Region F */
SELECT region_overlaps_element(9, 3, 0.4, 0.6, 0.5, 0.8);
/* 1: Region G */
SELECT region_overlaps_element(9, 3, 0.05, 0.6, 0.35, 0.95);
/* 1: Region H */
SELECT region_overlaps_element(9, 3, 0.75, 0.85, 0.95, 0.95);
/* 1: Region I */
SELECT region_overlaps_element(9, 3, 0.21, 0.15, 0.24, 0.24);
/* 1: Region J */
SELECT region_overlaps_element(9, 3, 0.26, 0.29, 0.26, 0.29);
/* 1: Region K */
SELECT region_overlaps_element(9, 3, 0.05, 0.05, 0.95, 0.6);
/* 1: Region K (inverted points) */
SELECT region_overlaps_element(9, 3, 0.95, 0.6, 0.05, 0.05);
