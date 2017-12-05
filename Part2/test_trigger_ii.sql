/*
CASE STUDY 1
'2017-08-14 10:03:27', '2017-10-10 14:11:20', 11, 81728596, 'GE Healthcare'
*/
/* No overlapping period (fully before) */
INSERT INTO Period VALUES ('2017-06-10 10:03:27', '2017-08-10 14:11:20');
/* No overlapping period (fully after) */
INSERT INTO Period VALUES ('2017-10-12 10:03:27', '2017-10-20 14:11:20');
/* Overlapping Period (fully inside) */
INSERT INTO Period VALUES ('2017-08-20 10:03:27', '2017-09-11 14:11:20');
/* Overlapping Period (fully inside larger) */
INSERT INTO Period VALUES ('2017-07-14 10:03:27', '2017-11-10 14:11:20');
/* Overlapping Period (end inside) */
INSERT INTO Period VALUES ('2017-07-14 10:03:27', '2017-08-25 14:11:20');
/* Overlapping Period (start inside) */
INSERT INTO Period VALUES ('2017-09-14 10:03:27', '2017-10-25 14:11:20');

/* OK : No overlapping period (fully before) */
INSERT INTO Wears VALUES ('2017-06-10 10:03:27', '2017-08-10 14:11:20', 1, 81728596, 'GE Healthcare');
/* OK : No overlapping period (fully after) */
INSERT INTO Wears VALUES ('2017-10-12 10:03:27', '2017-10-20 14:11:20', 1, 81728596, 'GE Healthcare');
/* NOT OK : Overlapping Period (fully inside) */
INSERT INTO Wears VALUES ('2017-08-20 10:03:27', '2017-09-11 14:11:20', 1, 81728596, 'GE Healthcare');
/* NOT OK: Overlapping Period (fully inside larger) */
INSERT INTO Wears VALUES ('2017-07-14 10:03:27', '2017-11-10 14:11:20', 1, 81728596, 'GE Healthcare');
/* NOT OK : Overlapping Period (end inside) */
INSERT INTO Wears VALUES ('2017-07-14 10:03:27', '2017-08-25 14:11:20', 1, 81728596, 'GE Healthcare');
/* NOT OK : Overlapping Period (start inside) */
INSERT INTO Wears VALUES ('2017-09-14 10:03:27', '2017-10-25 14:11:20', 1, 81728596, 'GE Healthcare');

/*
CASE STUDY 2
'2017-06-04 12:43:54', '2017-10-17 13:34:28', 12, 50524548, 'Philips Healthcare'
*/
/* No overlapping period (fully before) */
INSERT INTO Period VALUES ('2017-03-11 10:03:27', '2017-05-10 14:11:20');
/* No overlapping period (fully after) */
INSERT INTO Period VALUES ('2017-10-18 10:03:27', '2017-10-25 14:11:20');
/* Overlapping Period (fully inside) */
INSERT INTO Period VALUES ('2017-07-20 10:03:27', '2017-09-11 14:11:20');
/* Overlapping Period (fully inside larger) */
INSERT INTO Period VALUES ('2017-05-14 10:03:27', '2017-11-10 14:11:20');
/* Overlapping Period (end inside) */
INSERT INTO Period VALUES ('2017-05-14 10:03:27', '2017-08-25 14:11:20');
/* Overlapping Period (start inside) */
INSERT INTO Period VALUES ('2017-09-14 10:03:27', '2017-10-26 14:11:20');

/* No overlapping period (fully before) */
INSERT INTO Wears VALUES ('2017-03-11 10:03:27', '2017-05-10 14:11:20', 20, 50524548, 'Philips Healthcare');
/* No overlapping period (fully after) */
INSERT INTO Wears VALUES ('2017-10-18 10:03:27', '2017-10-25 14:11:20', 20, 50524548, 'Philips Healthcare');
/* Overlapping Period (fully inside) */
INSERT INTO Wears VALUES ('2017-07-20 10:03:27', '2017-09-11 14:11:20', 20, 50524548, 'Philips Healthcare');
/* Overlapping Period (fully inside larger) */
INSERT INTO Wears VALUES ('2017-05-14 10:03:27', '2017-11-10 14:11:20', 20, 50524548, 'Philips Healthcare');
/* Overlapping Period (end inside) */
INSERT INTO Wears VALUES ('2017-05-14 10:03:27', '2017-08-25 14:11:20', 20, 50524548, 'Philips Healthcare');
/* Overlapping Period (start inside) */
INSERT INTO Wears VALUES ('2017-09-14 10:03:27', '2017-10-26 14:11:20', 20, 50524548, 'Philips Healthcare');

/*
CASE STUDY 3 - UPDATE - CHANGING BOTH DATES AND KEEPING THE SAME DEVICE
ORIGINAL: '2017-01-05 08:05:24', '2017-03-24 10:40:19', 13, 93396993, 'Siemens Healthcare'
ADD: '2016-10-05 08:05:24', '2016-11-05 10:43:19', 13, 93396993, 'Siemens Healthcare'
*/
/* Add target */
INSERT INTO Period VALUES ('2016-10-05 08:05:24', '2016-11-05 10:43:19');
INSERT INTO Wears VALUES ('2016-10-05 08:05:24', '2016-11-05 10:43:19', 13, 93396993, 'Siemens Healthcare');

/* Overlap F */
INSERT INTO Period VALUES ('2017-02-01 08:05:24', '2017-02-20 10:43:19');
UPDATE Wears SET start='2017-02-01 08:05:24', end='2017-02-20 10:43:19' WHERE patient=13 AND start='2016-10-05 08:05:24' AND end='2016-11-05 10:43:19';

/* Overlap H */
INSERT INTO Period VALUES ('2017-01-01 08:05:24', '2017-02-20 10:43:19');
UPDATE Wears SET start='2017-01-01 08:05:24', end='2017-02-20 10:43:19' WHERE patient=13 AND start='2016-10-05 08:05:24' AND end='2016-11-05 10:43:19';

/* Overlap I */
INSERT INTO Period VALUES ('2017-01-01 08:05:24', '2017-02-20 10:43:20');
UPDATE Wears SET start='2017-01-01 08:05:24', end='2017-02-20 10:43:20' WHERE patient=13 AND start='2016-10-05 08:05:24' AND end='2016-11-05 10:43:19';

/* Overlap K */
INSERT INTO Period VALUES ('2017-01-01 08:05:24', '2017-04-20 10:43:19');
UPDATE Wears SET start='2017-01-01 08:05:24', end='2017-04-20 10:43:19' WHERE patient=13 AND start='2016-10-05 08:05:24' AND end='2016-11-05 10:43:19';

/* Overlap L */
INSERT INTO Period VALUES ('2016-10-20 08:05:24', '2017-02-20 10:43:19');
UPDATE Wears SET start='2016-10-20 08:05:24', end='2017-02-20 10:43:19' WHERE patient=13 AND start='2016-10-05 08:05:24' AND end='2016-11-05 10:43:19';

/* Overlap M */
INSERT INTO Period VALUES ('2016-10-01 08:05:24', '2017-04-20 10:43:19');
UPDATE Wears SET start='2016-10-01 08:05:24', end='2017-04-20 10:43:19' WHERE patient=13 AND start='2016-10-05 08:05:24' AND end='2016-11-05 10:43:19';

/* No overlap A */
INSERT INTO Period VALUES ('2016-09-01 08:05:24', '2016-09-20 10:43:19');
UPDATE Wears SET start='2016-09-01 08:05:24', end='2016-09-20 10:43:19' WHERE patient=13 AND start='2016-10-05 08:05:24' AND end='2016-11-05 10:43:19';
DELETE FROM Wears WHERE start='2016-09-01 08:05:24' AND end='2016-09-20 10:43:19' AND patient=13;
INSERT INTO Wears VALUES ('2016-10-05 08:05:24', '2016-11-05 10:43:19', 13, 93396993, 'Siemens Healthcare');

/* No overlap B */
INSERT INTO Period VALUES ('2016-10-10 08:05:24', '2016-10-20 10:43:19');
UPDATE Wears SET start='2016-10-10 08:05:24', end='2016-10-20 10:43:19' WHERE patient=13 AND start='2016-10-05 08:05:24' AND end='2016-11-05 10:43:19';
DELETE FROM Wears WHERE start='2016-10-10 08:05:24' AND end='2016-10-20 10:43:19' AND patient=13;
INSERT INTO Wears VALUES ('2016-10-05 08:05:24', '2016-11-05 10:43:19', 13, 93396993, 'Siemens Healthcare');

/* No overlap C */
INSERT INTO Period VALUES ('2016-10-01 08:05:24', '2016-10-20 10:43:19');
UPDATE Wears SET start='2016-10-01 08:05:24', end='2016-10-20 10:43:19' WHERE patient=13 AND start='2016-10-05 08:05:24' AND end='2016-11-05 10:43:19';
DELETE FROM Wears WHERE start='2016-10-01 08:05:24' AND end='2016-10-20 10:43:19' AND patient=13;
INSERT INTO Wears VALUES ('2016-10-05 08:05:24', '2016-11-05 10:43:19', 13, 93396993, 'Siemens Healthcare');

/* No overlap D */
INSERT INTO Period VALUES ('2016-11-10 08:05:24', '2016-11-20 10:43:19');
UPDATE Wears SET start='2016-11-10 08:05:24', end='2016-11-20 10:43:19' WHERE patient=13 AND start='2016-10-05 08:05:24' AND end='2016-11-05 10:43:19';
DELETE FROM Wears WHERE start='2016-11-10 08:05:24' AND end='2016-11-20 10:43:19' AND patient=13;
INSERT INTO Wears VALUES ('2016-10-05 08:05:24', '2016-11-05 10:43:19', 13, 93396993, 'Siemens Healthcare');

/* No overlap E */
INSERT INTO Period VALUES ('2016-11-01 08:05:24', '2016-11-20 10:43:19');
UPDATE Wears SET start='2016-11-01 08:05:24', end='2016-11-20 10:43:19' WHERE patient=13 AND start='2016-10-05 08:05:24' AND end='2016-11-05 10:43:19';
DELETE FROM Wears WHERE start='2016-11-01 08:05:24' AND end='2016-11-20 10:43:19' AND patient=13;
INSERT INTO Wears VALUES ('2016-10-05 08:05:24', '2016-11-05 10:43:19', 13, 93396993, 'Siemens Healthcare');

/* No overlap J */
INSERT INTO Period VALUES ('2016-10-01 08:05:24', '2016-11-20 10:43:19');
UPDATE Wears SET start='2016-10-01 08:05:24', end='2016-11-20 10:43:19' WHERE patient=13 AND start='2016-10-05 08:05:24' AND end='2016-11-05 10:43:19';
DELETE FROM Wears WHERE start='2016-10-01 08:05:24' AND end='2016-11-20 10:43:19' AND patient=13;
INSERT INTO Wears VALUES ('2016-10-05 08:05:24', '2016-11-05 10:43:19', 13, 93396993, 'Siemens Healthcare');

/* No overlap G */
INSERT INTO Period VALUES ('2017-04-01 08:05:24', '2017-04-20 10:43:19');
UPDATE Wears SET start='2017-04-01 08:05:24', end='2017-04-20 10:43:19' WHERE patient=13 AND start='2016-10-05 08:05:24' AND end='2016-11-05 10:43:19';
DELETE FROM Wears WHERE start='2017-04-01 08:05:24' AND end='2017-04-20 10:43:19' AND patient=13;
INSERT INTO Wears VALUES ('2016-10-05 08:05:24', '2016-11-05 10:43:19', 13, 93396993, 'Siemens Healthcare');

/*
CASE STUDY 4 - UPDATE - CHANGING DEVICE AND KEEPING BOTH DATES
ORIGINAL: '2016-11-24 11:22:38', '2016-12-11 06:23:21', 9, 80558661, 'Medtronic'
REPLACE ERROR: '2016-11-17 06:30:06', '2016-12-03 03:38:15', 4, 80558661, 'Johnson & Johnson'
REPLACE NO ERROR: '2017-09-03 16:40:36', '2017-12-04 17:33:23', 12, 1938116, 'Philips Healthcare'
REPLACE NO ERROR: '2017-01-05 08:05:24', '2017-03-24 10:40:19', 13, 93396993, 'Siemens Healthcare'
REPLACE ERROR: '2017-10-02 02:14:14', '2017-10-22 09:26:16', 20, 3089614, 'Siemens Healthcare'

*/
/* if made by this order...*/
/* ERROR */
UPDATE Wears SET snum=80558661, manuf='Johnson & Johnson' WHERE patient=9 AND start='2016-11-24 11:22:38' AND end='2016-12-11 06:23:21';
/* NO ERROR */
UPDATE Wears SET snum=80558661, manuf='Johnson & Johnson' WHERE patient=12 AND start='2017-09-03 16:40:36' AND end='2017-12-04 17:33:23';
/* NO ERROR */
UPDATE Wears SET snum=80558661, manuf='Johnson & Johnson' WHERE patient=13 AND start='2017-01-05 08:05:24' AND end='2017-03-24 10:40:19';
/* ERROR */
UPDATE Wears SET snum=80558661, manuf='Johnson & Johnson' WHERE patient=20 AND start='2017-10-02 02:14:14' AND end='2017-10-22 09:26:16';