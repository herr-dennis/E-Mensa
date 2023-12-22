CREATE VIEW view_suppengerichte AS
SELECT *
FROM gericht
WHERE LOWER(name) LIKE '%suppe%';

SELECT * FROM view_suppengerichte;


CREATE VIEW view_anmeldungen AS SELECT anzahlanmeldungen FROM benutzer ORDER BY anzahlanmeldungen desc ;
SELECT anzahlanmeldungen FROM benutzer ORDER BY anzahlanmeldungen desc

/*
CREATE VIEW view_kategoriegerichte_vegetarisch AS
SELECT
    kategorie.name AS kategorie_name,
    gericht.name AS gericht_name,
    gericht.vegaetarisch
FROM
    kategorie
        RIGHT JOIN
    gericht_hat_kategorie ghk ON kategorie.id = ghk.kategorie_id
        RIGHT JOIN
    gericht ON ghk.gericht_id = gericht.id
WHERE
        gericht.vegaetarisch = 1 ;

*/
/* Über die Fremdschlüssel*/
CREATE VIEW view__kategoriegerichte_vegetarisch  AS
SELECT
    kategorie.name AS kategorie_name,
    gericht.name AS gericht_name

FROM
    kategorie
        RIGHT JOIN
    gericht ON kategorie.id = gericht.id
WHERE
        gericht.vegaetarisch = 1 OR gericht.vegaetarisch IS NULL;