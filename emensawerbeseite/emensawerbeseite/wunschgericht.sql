create table emensawerbeseite.wunschgericht
(
    gericht_name    varchar(200) null,
    wid             int auto_increment
        primary key,
    beschreibung    varchar(400) null,
    erfassung_datum varchar(200) null,
    ersteller_mail  varchar(200) null,
    constraint wunschgericht_ibfk_1
        foreign key (ersteller_mail) references emensawerbeseite.ersteller (email)
);

create index ersteller_mail
    on emensawerbeseite.wunschgericht (ersteller_mail);

