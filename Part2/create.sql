/* DROP ALL TABLES AND CREATE NEW ONES */
DROP TABLE IF EXISTS Wears;
DROP TABLE IF EXISTS Region;
DROP TABLE IF EXISTS Element;
DROP TABLE IF EXISTS Series;
DROP TABLE IF EXISTS Study;
DROP TABLE IF EXISTS Request;
DROP TABLE IF EXISTS Doctor;
DROP TABLE IF EXISTS Patient;
DROP TABLE IF EXISTS Reading;
DROP TABLE IF EXISTS Sensor;
DROP TABLE IF EXISTS Device;
DROP TABLE IF EXISTS Period;

CREATE TABLE Patient (
  number   INTEGER,
  name     VARCHAR(255),
  birthday DATE,
  address  VARCHAR(255),
  PRIMARY KEY (number)
);

CREATE TABLE Doctor (
  number    INTEGER,
  doctor_id INTEGER,
  PRIMARY KEY (doctor_id),
  FOREIGN KEY (number) REFERENCES Patient (number)
);

CREATE TABLE Device (
  serialnum    INTEGER,
  manufacturer VARCHAR(255),
  model        VARCHAR(255),
  PRIMARY KEY (serialnum, manufacturer)
);

CREATE TABLE Sensor (
  snum  INTEGER,
  manuf VARCHAR(255),
  units VARCHAR(255),
  PRIMARY KEY (snum, manuf, units),
  FOREIGN KEY (snum, manuf) REFERENCES Device (serialnum, manufacturer)
);

CREATE TABLE Reading (
  snum     INTEGER,
  manuf    VARCHAR(255),
  datetime DATETIME,
  value    FLOAT,
  PRIMARY KEY (snum, manuf, datetime),
  FOREIGN KEY (snum, manuf) REFERENCES Sensor (snum, manuf)
);

CREATE TABLE Period (
  start DATETIME,
  end   DATETIME,
  PRIMARY KEY (start, end)
);

CREATE TABLE Wears (
  start   DATETIME,
  end     DATETIME,
  patient INTEGER,
  snum    INTEGER,
  manuf   VARCHAR(255),
  PRIMARY KEY (start, end, patient),
  FOREIGN KEY (start, end) REFERENCES Period (start, end),
  FOREIGN KEY (patient) REFERENCES Patient (number),
  FOREIGN KEY (snum, manuf) REFERENCES Device (serialnum, manufacturer)
);

CREATE TABLE Request (
  number     INTEGER,
  patient_id INTEGER,
  doctor_id  INTEGER,
  date       DATE,
  PRIMARY KEY (number),
  FOREIGN KEY (patient_id) REFERENCES Patient (number),
  FOREIGN KEY (doctor_id) REFERENCES Doctor (doctor_id)
);

CREATE TABLE Study (
  request_number INTEGER,
  description    VARCHAR(255),
  date           DATE,
  doctor_id      INTEGER,
  manufacturer   VARCHAR(255),
  serial_number  INTEGER,
  PRIMARY KEY (request_number, description),
  FOREIGN KEY (request_number) REFERENCES Request (number),
  FOREIGN KEY (doctor_id) REFERENCES Doctor (doctor_id),
  FOREIGN KEY (serial_number, manufacturer) REFERENCES Device (serialnum, manufacturer)
);

CREATE TABLE Series (
  series_id      INTEGER,
  name           VARCHAR(255),
  base_url       VARCHAR(255),
  request_number INTEGER,
  description    VARCHAR(255),
  PRIMARY KEY (series_id),
  FOREIGN KEY (request_number, description) REFERENCES Study (request_number, description)
);

CREATE TABLE Element (
  series_id     INTEGER,
  element_index INTEGER,
  PRIMARY KEY (series_id, element_index),
  FOREIGN KEY (series_id) REFERENCES Series (series_id)
);

CREATE TABLE Region (
  series_id  INTEGER,
  elem_index INTEGER,
  x1         FLOAT,
  y1         FLOAT,
  x2         FLOAT,
  y2         FLOAT,
  PRIMARY KEY (series_id, elem_index, x1, y1, x2, y2),
  FOREIGN KEY (series_id, elem_index) REFERENCES Element (series_id, element_index)
);