CREATE INDEX uzytkownik_name ON uzytkownik(nazwa_uzytkownika);

analyze table film compute statistics;
analyze table uzytkownik compute statistics;
analyze table pozycja compute statistics;
analyze index uzytkownik_name compute statistics;