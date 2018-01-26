CREATE VIEW lista_do_obejrzenia (pozycja, tytul, rok_produkcji, gatunek, rezyser_imie, rezyser_nazwisko, czas_trwania, srednia_ocen, priorytet, uzytkownik_id) AS
SELECT poz.pozycja, f.tytul, f.rok_produkcji, g.nazwa, r.imie, r.nazwisko, f.czas_trwania, f.srednia_ocen, pr.opis, poz.uzytkownik_id
FROM pozycja poz LEFT JOIN film f ON poz.film_id = f.id LEFT JOIN priorytet pr ON poz.priorytet_id = pr.id LEFT JOIN gatunek g ON f.gatunek_id = g.id LEFT JOIN rezyser r ON f.rezyser_id = r.id LEFT JOIN uzytkownik u ON poz.uzytkownik_id = u.id;

CREATE SEQUENCE id_uzytkownik_s
START WITH 1
INCREMENT BY 1;

CREATE SEQUENCE id_ocena_s
START WITH 1
INCREMENT BY 1;

CREATE OR REPLACE TRIGGER id_uzytkownik_trigger
BEFORE INSERT ON osoba
FOR EACH ROW
BEGIN
  SELECT id_uzytkownik_s_seq.nextval INTO :NEW.id FROM dual;
END;
/

CREATE OR REPLACE TRIGGER id_ocena_trigger
BEFORE INSERT ON ocena_filmu
FOR EACH ROW
BEGIN
  SELECT id_ocena_s_seq.nextval INTO :NEW.id FROM dual;
END;
/