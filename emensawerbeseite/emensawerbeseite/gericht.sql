create table emensawerbeseite.gericht
(
    id           bigint       not null
        primary key,
    name         varchar(80)  not null,
    beschreibung varchar(900) not null,
    erfasst_am   date         not null,
    vegaetarisch tinyint(1)   not null,
    vegan        tinyint(1)   not null,
    preisintern  double       not null,
    preisextern  double       not null
        check (`preisextern` >= `preisintern`),
    constraint name
        unique (name),
    constraint name_2
        unique (name)
);

