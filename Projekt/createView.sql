CREATE VIEW lista_do_obejrzenia (pozycja, tytul, rok_produkcji, gatunek, rezyser_imie, rezyser_nazwisko, czas_trwania, srednia_ocen, priorytet, uzytkownik_id) AS
SELECT poz.pozycja, f.tytul, f.rok_produkcji, g.nazwa, r.imie, r.nazwisko, f.czas_trwania, f.srednia_ocen, pr.opis, poz.uzytkownik_id
FROM pozycja poz LEFT JOIN film f ON poz.film_id = f.id LEFT JOIN priorytet pr ON poz.priorytet_id = pr.id LEFT JOIN gatunek g ON f.gatunek_id = g.id LEFT JOIN rezyser r ON f.rezyser_id = r.id LEFT JOIN uzytkownik u ON poz.uzytkownik_id = u.id;

ALTER VIEW lista_do_obejrzenia ADD CONSTRAINT no_duplicates UNIQUE ( tytul, uzytkownik_id );

CREATE SEQUENCE id_nowy_uzytkownik
START WITH 1
INCREMENT BY 1;

CREATE SEQUENCE id_opinia
START WITH 1
INCREMENT BY 1;

CREATE TRIGGER id_uzytkownik_trigger
BEFORE INSERT ON osoba
FOR EACH ROW
BEGIN
  SELECT id_nowy_uzytkownik_seq.nextval INTO :NEW.id FROM dual;
END;
/

CREATE TRIGGER id_opinia_trigger
BEFORE INSERT ON opinia
FOR EACH ROW
BEGIN
  SELECT id_opinia_seq.nextval INTO :NEW.id FROM dual;
END;
/