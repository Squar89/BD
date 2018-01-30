EXPLAIN PLAN FOR SELECT srednia_ocen, tytul, rok_produkcji, czas_trwania FROM film LEFT JOIN gatunek ON film.gatunek_id = gatunek.id LEFT JOIN rezyser ON film.rezyser_id = rezyser.id WHERE srednia_ocen > 6.1 AND rok_produkcji < 2010 AND czas_trwania < 180;
SELECT * FROM TABLE(dbms_xplan.display);

@optimize.sql

EXPLAIN PLAN FOR SELECT srednia_ocen, tytul, rok_produkcji, czas_trwania FROM film LEFT JOIN gatunek ON film.gatunek_id = gatunek.id LEFT JOIN rezyser ON film.rezyser_id = rezyser.id WHERE srednia_ocen > 6.1 AND rok_produkcji < 2010 AND czas_trwania < 180;
SELECT * FROM TABLE(dbms_xplan.display);