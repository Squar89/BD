DROP TABLE PILKARZE;
DROP TABLE GOLE;
DROP TABLE PILKARZE_W_DRUZYNACH;
DROP TABLE DRUZYNY;
DROP TABLE MECZE;

CREATE TABLE PILKARZE (
	pesel CHAR(11) PRIMARY KEY,
	imie VARCHAR2(20) NOT NULL,
	nazwisko VARCHAR2(20) NOT NULL
);

CREATE TABLE DRUZYNY (
	nazwa VARCHAR2(30) PRIMARY KEY
);

