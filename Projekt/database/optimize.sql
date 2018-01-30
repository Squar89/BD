CREATE INDEX film_index ON film(rok_produkcji, czas_trwania, srednia_ocen);

analyze table film compute statistics;
analyze table uzytkownik compute statistics;
analyze table pozycja compute statistics;
analyze index film_index compute statistics;
