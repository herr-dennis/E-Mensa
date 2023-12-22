create table emensawerbeseite.benutzer
(
    id                bigint auto_increment
        primary key,
    name              varchar(200) not null,
    email             varchar(100) not null,
    passwort          varchar(200) not null,
    admin             tinyint(1)   not null,
    anzahlfehler      int          not null,
    anzahlanmeldungen int          not null,
    letzteanmeldung   datetime     null,
    letzterfehler     datetime     null,
    salt              varchar(50)  not null,
    constraint email
        unique (email)
);

