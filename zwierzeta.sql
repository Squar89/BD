--
-- Oskar Skibski, http://www.mimuw.edu.pl/~oski/bd/
-- 
-- Przykladowy baza danych osob i ich zwierzat
-- 

DROP TABLE posiadanie;
DROP TABLE zwierze;
DROP TABLE osoba;

CREATE TABLE osoba (
  imie VARCHAR2(20) PRIMARY KEY,
  nazwisko VARCHAR2(30) NOT NULL,
  mama VARCHAR2(20) REFERENCES osoba,
  tata VARCHAR2(20) REFERENCES osoba
);

CREATE TABLE zwierze (
  idzwierzecia NUMBER(3) PRIMARY KEY,
  imie VARCHAR2(20) NOT NULL,
  gatunek VARCHAR2(20) NOT NULL,
  datasmierci DATE
);

CREATE TABLE posiadanie (
  imiewlasciciela NOT NULL REFERENCES osoba,
  idzwierzecia NUMBER(3) NOT NULL REFERENCES zwierze,
  dataprzygarniecia DATE NOT NULL,
  PRIMARY KEY (imiewlasciciela, idzwierzecia)
);


INSERT INTO osoba VALUES ('Ewa', 'Pobozna', NULL, NULL);
INSERT INTO osoba VALUES ('Adam', 'Pobozny', NULL, NULL);
INSERT INTO osoba VALUES ('Grzegorz', 'Markowy', 'Ewa', NULL);
INSERT INTO osoba VALUES ('Tomek', 'Kowalski', 'Ewa', 'Adam');
INSERT INTO osoba VALUES ('Agnieszka', 'Nieznana', 'Ewa', NULL);
INSERT INTO osoba VALUES ('Marek', 'Nowak', 'Agnieszka', 'Tomek');
INSERT INTO osoba VALUES ('Wojtek', 'Nowak', 'Ewa', 'Grzegorz');
INSERT INTO osoba VALUES ('Ala', 'Makota', 'Agnieszka', NULL);
INSERT INTO osoba VALUES ('Julia', 'Cokolwiek', 'Ala', 'Grzegorz');

INSERT INTO zwierze VALUES (1, 'Mruczek', 'kot', NULL);
INSERT INTO zwierze VALUES (2, 'Reksio', 'pies', NULL);
INSERT INTO zwierze VALUES (3, 'Ira', 'pies', '20-JAN-01');
INSERT INTO zwierze VALUES (4, 'Bonifacy', 'kot', '10-JUN-01');
INSERT INTO zwierze VALUES (5, 'Dumbo', 'slon', '17-OCT-01');
INSERT INTO zwierze VALUES (6, 'Chichi', 'pies', '30-MAY-02');
INSERT INTO zwierze VALUES (7, 'Miau', 'kot', NULL);
INSERT INTO zwierze VALUES (8, 'Ogonek', 'zolw', NULL);
INSERT INTO zwierze VALUES (9, 'Kacper', 'papuga', NULL);
INSERT INTO zwierze VALUES (10, 'Mruczek', 'kot', NULL);
INSERT INTO zwierze VALUES (11, 'Ira', 'pies', '16-MAY-01');

INSERT INTO posiadanie VALUES ('Ala', 1, '10-JAN-01');
INSERT INTO posiadanie VALUES ('Ala', 5, '05-JAN-01');
INSERT INTO posiadanie VALUES ('Ala', 8, '01-JAN-01');
INSERT INTO posiadanie VALUES ('Wojtek', 2, '01-JAN-02');
INSERT INTO posiadanie VALUES ('Wojtek', 6, '30-MAY-01');
INSERT INTO posiadanie VALUES ('Wojtek', 11, '01-OCT-02');
INSERT INTO posiadanie VALUES ('Tomek', 3, '07-JUN-07');
INSERT INTO posiadanie VALUES ('Tomek', 10, '24-DEC-05');
INSERT INTO posiadanie VALUES ('Julia', 4, '10-SEP-10');
