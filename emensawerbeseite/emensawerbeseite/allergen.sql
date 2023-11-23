create table emensawerbeseite.allergen
(
    code char(4)      not null
        primary key,
    name varchar(300) not null,
    typ  varchar(20)  not null
);

