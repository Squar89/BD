CREATE OR REPLACE TRIGGER update_rating
AFTER INSERT ON ocena_filmu
FOR EACH ROW
BEGIN
  IF :NEW.ocena IS NOT NULL THEN
    UPDATE film SET film.liczba_ocen = film.liczba_ocen + 1 WHERE film.id = :NEW.film_id;
    UPDATE film SET film.srednia_ocen = CAST(CAST(film.srednia_ocen AS number(*, 2))
                                      + ((CAST(:NEW.ocena AS number(*, 2)) - CAST(film.srednia_ocen AS number(*, 2))) / CAST(film.liczba_ocen AS number(*, 2))) AS number(*, 2)
                WHERE film.id = :NEW.film_id;
  END IF;
END;
/