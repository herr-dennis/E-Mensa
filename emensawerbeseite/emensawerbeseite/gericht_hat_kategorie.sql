create table emensawerbeseite.gericht_hat_kategorie
(
    gericht_id   bigint not null,
    kategorie_id bigint not null,
    constraint gericht_hat_kategorie_ibfk_1
        foreign key (gericht_id) references emensawerbeseite.gericht (id),
    constraint gericht_hat_kategorie_ibfk_2
        foreign key (kategorie_id) references emensawerbeseite.kategorie (id)
);

create index gericht_id
    on emensawerbeseite.gericht_hat_kategorie (gericht_id);

create index kategorie_id
    on emensawerbeseite.gericht_hat_kategorie (kategorie_id);

