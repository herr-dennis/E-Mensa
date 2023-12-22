create definer = root@localhost view emensawerbeseite.view_anmeldungen as
select `emensawerbeseite`.`benutzer`.`anzahlanmeldungen` AS `anzahlanmeldungen`
from `emensawerbeseite`.`benutzer`
order by `emensawerbeseite`.`benutzer`.`anzahlanmeldungen` desc;

