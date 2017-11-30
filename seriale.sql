--
-- Oskar Skibski, http://www.mimuw.edu.pl/~oski/bd/
-- 
-- Przykladowy baza danych seriali
-- 

DROP TABLE postac;
DROP TABLE serial;
DROP TABLE kanal;

CREATE TABLE kanal (
  idkanalu NUMBER(5) PRIMARY KEY,
  nazwa VARCHAR2(40) NOT NULL,
  rokpowstania NUMBER(4) NOT NULL
);

CREATE TABLE serial (
  idserialu NUMBER(5) PRIMARY KEY,
  nazwa VARCHAR2(40) NOT NULL,
  rokstart NUMBER(4) NOT NULL,
  rokkoniec NUMBER(4),
  idkanalu NOT NULL REFERENCES kanal,
  ocena NUMBER(2) NOT NULL
);

CREATE TABLE postac	(
  idpostaci NUMBER(5) PRIMARY KEY,
  postac VARCHAR2(40) NOT NULL,
  ginie CHAR(3) NOT NULL,
  idserialu NOT NULL REFERENCES serial
);

INSERT INTO kanal VALUES (1, 'HBO', 1972);
INSERT INTO kanal VALUES (2, 'AMC', 1984);
INSERT INTO kanal VALUES (3, 'NBC', 1939);
INSERT INTO kanal VALUES (4, 'Netflix', 1997);
INSERT INTO kanal VALUES (5, 'Fox', 1939);

INSERT INTO serial VALUES (1, 'Friends', 1994, 2004, 3, 10);
INSERT INTO serial VALUES (2, 'House of Cards', 2013, NULL, 4, 10);
INSERT INTO serial VALUES (3, 'The Sopranos', 1999, 2007, 1, 7);
INSERT INTO serial VALUES (4, 'Game of Thrones', 2011, NULL, 1, 3);
INSERT INTO serial VALUES (5, 'Breaking Bad', 2008, 2013, 2, 9);
INSERT INTO serial VALUES (6, 'The Office', 2005, 2013, 3, 8);
INSERT INTO serial VALUES (7, 'The Wire', 2002, 2008, 1, 9);

INSERT INTO postac VALUES (1, 'Ross', 'nie', 1);
INSERT INTO postac VALUES (2, 'Rachel', 'nie', 1);
INSERT INTO postac VALUES (3, 'Chandler', 'nie', 1);
INSERT INTO postac VALUES (4, 'Monica', 'tak', 1);
INSERT INTO postac VALUES (5, 'Phoebe', 'tak', 1);
INSERT INTO postac VALUES (6, 'Joey', 'nie', 1);
INSERT INTO postac VALUES (7, 'Frank Underwood', 'nie', 2);
INSERT INTO postac VALUES (8, 'Claire Underwood', 'tak', 2);
INSERT INTO postac VALUES (9, 'Tony Soprano', 'nie', 3);
INSERT INTO postac VALUES (10, 'Ned Stark', 'tak', 4);
INSERT INTO postac VALUES (11, 'Cersei Lanister', 'tak', 4);
INSERT INTO postac VALUES (12, 'Daenerys Targaryen', 'tak', 4);
INSERT INTO postac VALUES (13, 'Walter White', 'nie', 5);
INSERT INTO postac VALUES (14, 'Jesse Pinkman', 'nie', 5);
INSERT INTO postac VALUES (15, 'Skyler', 'tak', 5);
INSERT INTO postac VALUES (16, 'Jim Halpert', 'tak', 6);
INSERT INTO postac VALUES (17, 'Michael Scott', 'nie', 6);


COMMIT;