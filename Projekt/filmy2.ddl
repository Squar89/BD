CREATE TABLE film (
    id              INTEGER NOT NULL,
    tytul           VARCHAR2(100 CHAR) NOT NULL,
    rok_produkcji   VARCHAR2(4 CHAR) NOT NULL,
    czas_trwania    INTEGER NOT NULL,
    srednia_ocen    NUMBER(2, 2),
    liczba_ocen     INTEGER NOT NULL,
    gatunek_id      INTEGER NOT NULL,
    rezyser_id      INTEGER NOT NULL
);

ALTER TABLE film ADD CONSTRAINT film_pk PRIMARY KEY ( id );

CREATE TABLE gatunek (
    id      INTEGER NOT NULL,
    nazwa   VARCHAR2(30 CHAR) NOT NULL
);

ALTER TABLE gatunek ADD CONSTRAINT gatunek_pk PRIMARY KEY ( id );

CREATE TABLE ocena_filmu (
    id              INTEGER NOT NULL,
    opinia          VARCHAR2(200 CHAR),
    ocena           INTEGER,
    film_id         INTEGER NOT NULL,
    uzytkownik_id   INTEGER NOT NULL
);

ALTER TABLE ocena_filmu ADD CONSTRAINT ocena_filmu_pk PRIMARY KEY ( id,
uzytkownik_id );

CREATE TABLE pozycja (
    pozycja         INTEGER NOT NULL,
    film_id         INTEGER NOT NULL,
    priorytet_id    INTEGER NOT NULL,
    uzytkownik_id   INTEGER NOT NULL
);

ALTER TABLE pozycja ADD CONSTRAINT pozycja_pk PRIMARY KEY ( pozycja, uzytkownik_id );

ALTER TABLE pozycja ADD CONSTRAINT no_duplicates UNIQUE ( film_id, uzytkownik_id );

CREATE TABLE priorytet (
    id     INTEGER NOT NULL,
    opis   VARCHAR2(30 CHAR) NOT NULL
);

ALTER TABLE priorytet ADD CONSTRAINT priorytet_pk PRIMARY KEY ( id );

CREATE TABLE rezyser (
    id              INTEGER NOT NULL,
    imie            VARCHAR2(20 CHAR) NOT NULL,
    nazwisko        VARCHAR2(30 CHAR) NOT NULL
);

ALTER TABLE rezyser ADD CONSTRAINT rezyser_pk PRIMARY KEY ( id );

CREATE TABLE uzytkownik (
    id                  INTEGER NOT NULL,
    nazwa_uzytkownika   VARCHAR2(20 CHAR) NOT NULL
);

ALTER TABLE uzytkownik ADD CONSTRAINT uzytkownik_pk PRIMARY KEY ( id );

ALTER TABLE film
    ADD CONSTRAINT film_gatunek_fk FOREIGN KEY ( gatunek_id )
        REFERENCES gatunek ( id );

ALTER TABLE film
    ADD CONSTRAINT film_rezyser_fk FOREIGN KEY ( rezyser_id )
        REFERENCES rezyser ( id );

ALTER TABLE ocena_filmu
    ADD CONSTRAINT ocena_filmu_film_fk FOREIGN KEY ( film_id )
        REFERENCES film ( id );

ALTER TABLE ocena_filmu
    ADD CONSTRAINT ocena_filmu_uzytkownik_fk FOREIGN KEY ( uzytkownik_id )
        REFERENCES uzytkownik ( id );

ALTER TABLE pozycja
    ADD CONSTRAINT pozycja_film_fk FOREIGN KEY ( film_id )
        REFERENCES film ( id );

ALTER TABLE pozycja
    ADD CONSTRAINT pozycja_priorytet_fk FOREIGN KEY ( priorytet_id )
        REFERENCES priorytet ( id );

ALTER TABLE pozycja
    ADD CONSTRAINT pozycja_uzytkownik_fk FOREIGN KEY ( uzytkownik_id )
        REFERENCES uzytkownik ( id );

CREATE VIEW lista_do_obejrzenia (pozycja, tytul, rok_produkcji, gatunek, rezyser_imie, rezyser_nazwisko, czas_trwania, srednia_ocen, priorytet, uzytkownik_id) AS
SELECT poz.pozycja, f.tytul, f.rok_produkcji, g.nazwa, r.imie, r.nazwisko, f.czas_trwania, f.srednia_ocen, pr.opis, poz.uzytkownik_id
FROM pozycja poz LEFT JOIN film f ON poz.film_id = f.id LEFT JOIN priorytet pr ON poz.priorytet_id = pr.id LEFT JOIN gatunek g ON f.gatunek_id = g.id
                 LEFT JOIN rezyser r ON f.rezyser_id = r.id LEFT JOIN uzytkownik u ON poz.uzytkownik_id = u.id;

CREATE SEQUENCE id_uzytkownik_seq
START WITH 1
INCREMENT BY 1;

CREATE SEQUENCE id_ocena_seq
START WITH 1
INCREMENT BY 1;

CREATE OR REPLACE TRIGGER id_uzytkownik_trigger
BEFORE INSERT ON uzytkownik
FOR EACH ROW
BEGIN
  SELECT id_uzytkownik_seq.nextval INTO :NEW.id FROM dual;
END;
/

CREATE OR REPLACE TRIGGER id_ocena_trigger
BEFORE INSERT ON ocena_filmu
FOR EACH ROW
BEGIN
  SELECT id_ocena_seq.nextval INTO :NEW.id FROM dual;
END;
/