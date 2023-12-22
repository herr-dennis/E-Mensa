create definer = root@localhost view emensawerbeseite.view_suppengerichte as
select `emensawerbeseite`.`gericht`.`id`           AS `id`,
       `emensawerbeseite`.`gericht`.`name`         AS `name`,
       `emensawerbeseite`.`gericht`.`beschreibung` AS `beschreibung`,
       `emensawerbeseite`.`gericht`.`erfasst_am`   AS `erfasst_am`,
       `emensawerbeseite`.`gericht`.`vegaetarisch` AS `vegaetarisch`,
       `emensawerbeseite`.`gericht`.`vegan`        AS `vegan`,
       `emensawerbeseite`.`gericht`.`preisintern`  AS `preisintern`,
       `emensawerbeseite`.`gericht`.`preisextern`  AS `preisextern`,
       `emensawerbeseite`.`gericht`.`bildname`     AS `bildname`
from `emensawerbeseite`.`gericht`
where lcase(`emensawerbeseite`.`gericht`.`name`) like '%suppe%';

