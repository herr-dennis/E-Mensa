create definer = root@localhost view emensawerbeseite.view__kategoriegerichte_vegetarisch as
select `emensawerbeseite`.`kategorie`.`name` AS `kategorie_name`,
       `emensawerbeseite`.`gericht`.`name`   AS `gericht_name`
from (`emensawerbeseite`.`gericht` left join `emensawerbeseite`.`kategorie`
      on (`emensawerbeseite`.`kategorie`.`id` = `emensawerbeseite`.`gericht`.`id`))
where `emensawerbeseite`.`gericht`.`vegaetarisch` = 1
   or `emensawerbeseite`.`gericht`.`vegaetarisch` is null;

