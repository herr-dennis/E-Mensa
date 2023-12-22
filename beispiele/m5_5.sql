CREATE PROCEDURE increment_anzahlanmeldungen(IN user_id INT)
BEGIN
    UPDATE benutzer
    SET anzahlanmeldungen = anzahlanmeldungen + 1
    WHERE id = user_id;
END
