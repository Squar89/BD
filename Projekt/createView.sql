CREATE OR REPLACE TRIGGER update_rating
AFTER INSERT ON ocena_filmu
FOR EACH ROW
DECLARE
  incr int := 1;
BEGIN
  IF :NEW.ocena IS NOT NULL THEN
    UPDATE film
      SET film.liczba_ocen = (SELECT liczba_ocen + incr FROM film)
          film.srednia_ocen = film.srednia_ocen + ((:NEW.ocena - film.srednia_ocen) / film.liczba_ocen)
      WHERE film.id = :NEW.film_id;
  END IF;
END;
/