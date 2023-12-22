create
    definer = root@localhost procedure emensawerbeseite.increment_anzahlanmeldungen(IN user_id int)
BEGIN
    UPDATE benutzer
    SET anzahlanmeldungen = anzahlanmeldungen + 1
    WHERE id = user_id;
END;

