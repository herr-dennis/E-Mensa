create table emensawerbeseite.gericht_hat_allergenen
(
    code       char(4) null,
    gericht_id bigint  null,
    constraint fk_allergens
        foreign key (code) references emensawerbeseite.allergen (code)
            on update cascade,
    constraint fk_gericht
        foreign key (gericht_id) references emensawerbeseite.gericht (id)
            on update cascade
);

