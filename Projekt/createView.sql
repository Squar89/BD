CREATE VIEW lista_do_obejrzenia (pozycja, tytul, rok_produkcji, gatunek, rezyser_imie, rezyser_nazwisko, czas_trwania, srednia_ocen, priorytet, uzytkownik_id) AS
SELECT poz.pozycja, f.tytul, f.rok_produkcji, g.nazwa, r.imie, r.nazwisko, f.czas_trwania, f.srednia_ocen, pr.opis, poz.uzytkownik_id
FROM pozycja poz LEFT JOIN film f ON poz.film_id = f.id LEFT JOIN priorytet pr ON poz.priorytet_id = pr.id LEFT JOIN gatunek g ON f.gatunek_id = g.id LEFT JOIN rezyser r ON f.rezyser_id = r.id LEFT JOIN uzytkownik u ON poz.uzytkownik_id = u.id;

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

CREATE OR REPLACE TRIGGER update_rating
AFTER INSERT ON ocena_filmu
FOR EACH ROW UPDATE film
DECLARE
  incr int := 1;
BEGIN
  IF :NEW.ocena IS NOT NULL THEN
    SET film.liczba_ocen = (SELECT liczba_ocen + incr FROM film);
    SET film.srednia_ocen = film.srednia_ocen + ((:NEW.ocena - film.srednia_ocen) / film.liczba_ocen);
  END IF;
END;
WHERE film.id = :NEW.film_id;
/