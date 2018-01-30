EXPLAIN PLAN FOR SELECT f.id AS ID, f.tytul AS TYTUL, f.rok_produkcji AS ROK_PRODUKCJI, g.nazwa AS GATUNEK, r.imie AS IMIE_REZYSERA,
                        r.nazwisko AS NAZWISKO_REZYSERA, f.czas_trwania AS CZAS_TRWANIA, f.srednia_ocen AS OCENA
                 FROM film f LEFT JOIN gatunek g ON f.gatunek_id = g.id LEFT JOIN rezyser r ON f.rezyser_id = r.id
SELECT * FROM TABLE(dbms_xplan.display);

@optimize.sql

EXPLAIN PLAN FOR SELECT f.id AS ID, f.tytul AS TYTUL, f.rok_produkcji AS ROK_PRODUKCJI, g.nazwa AS GATUNEK, r.imie AS IMIE_REZYSERA,
                        r.nazwisko AS NAZWISKO_REZYSERA, f.czas_trwania AS CZAS_TRWANIA, f.srednia_ocen AS OCENA
                 FROM film f LEFT JOIN gatunek g ON f.gatunek_id = g.id LEFT JOIN rezyser r ON f.rezyser_id = r.id