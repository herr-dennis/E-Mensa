create table emensawerbeseite.kategorie
(
    id        bigint       not null
        primary key,
    name      varchar(80)  not null,
    eltern_id bigint       null,
    bildname  varchar(200) null,
    constraint kategorie_ibfk_1
        foreign key (eltern_id) references emensawerbeseite.kategorie (id)
);

create index eltern_id
    on emensawerbeseite.kategorie (eltern_id);

