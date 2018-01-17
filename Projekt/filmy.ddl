CREATE TABLE do_obejrzenia (
    id             INTEGER NOT NULL,
    priorytet_id   INTEGER NOT NULL,
    film_id        INTEGER NOT NULL
);

CREATE UNIQUE INDEX do_obejrzenia__idx ON
    do_obejrzenia ( film_id ASC );

ALTER TABLE do_obejrzenia ADD CONSTRAINT do_obejrzenia_pk PRIMARY KEY ( id );

CREATE TABLE film (
    id              INTEGER NOT NULL,
    tytul           VARCHAR2(100 CHAR) NOT NULL,
    rok_produkcji   VARCHAR2(4 CHAR) NOT NULL,
    czas_trwania    INTEGER NOT NULL,
    srednia_ocen    FLOAT,
    gatunek_id      INTEGER NOT NULL,
    rezyser_id      INTEGER NOT NULL,
    rezyser         INTEGER NOT NULL
);

CREATE UNIQUE INDEX film__idx ON
    film ( gatunek_id ASC );

CREATE UNIQUE INDEX film__idxv1 ON
    film ( rezyser_id ASC );

ALTER TABLE film ADD CONSTRAINT film_pk PRIMARY KEY ( id );

CREATE TABLE gatunek (
    id      INTEGER NOT NULL,
    nazwa   VARCHAR2(20 CHAR) NOT NULL
);

ALTER TABLE gatunek ADD CONSTRAINT gatunek_pk PRIMARY KEY ( id );

CREATE TABLE ocena_filmu (
    id                  INTEGER NOT NULL,
    nazwa_uzytkownika   VARCHAR2(20 CHAR) NOT NULL,
    opinia              VARCHAR2(300 CHAR),
    film_id             INTEGER NOT NULL
);

CREATE UNIQUE INDEX ocena_filmu__idx ON
    ocena_filmu ( film_id ASC );

ALTER TABLE ocena_filmu ADD CONSTRAINT ocena_filmu_pk PRIMARY KEY ( id );

CREATE TABLE priorytet (
    id     INTEGER NOT NULL,
    opis   VARCHAR2(20 CHAR) NOT NULL
);

ALTER TABLE priorytet ADD CONSTRAINT priorytet_pk PRIMARY KEY ( id );

CREATE TABLE rezyser (
    id              INTEGER NOT NULL,
    imie            VARCHAR2(20 CHAR) NOT NULL,
    nazwisko        VARCHAR2(20 CHAR) NOT NULL,
    rok_urodzenia   VARCHAR2(4 CHAR) NOT NULL
);

ALTER TABLE rezyser ADD CONSTRAINT rezyser_pk PRIMARY KEY ( id );

ALTER TABLE do_obejrzenia
    ADD CONSTRAINT do_obejrzenia_film_fk FOREIGN KEY ( film_id )
        REFERENCES film ( id );

ALTER TABLE do_obejrzenia
    ADD CONSTRAINT do_obejrzenia_priorytet_fk FOREIGN KEY ( priorytet_id )
        REFERENCES priorytet ( id );

ALTER TABLE film
    ADD CONSTRAINT film_gatunek_fk FOREIGN KEY ( gatunek_id )
        REFERENCES gatunek ( id );

ALTER TABLE film
    ADD CONSTRAINT film_rezyser_fk FOREIGN KEY ( rezyser_id )
        REFERENCES rezyser ( id );

ALTER TABLE ocena_filmu
    ADD CONSTRAINT ocena_filmu_film_fk FOREIGN KEY ( film_id )
        REFERENCES film ( id );
