create table emensawerbeseite.gericht_hat_allergenen
(
    code       char(4) null,
    gericht_id bigint  null,
    constraint gericht_hat_allergenen_ibfk_1
        foreign key (gericht_id) references emensawerbeseite.gericht (id),
    constraint gericht_hat_allergenen_ibfk_2
        foreign key (code) references emensawerbeseite.allergen (code)
);

create index code
    on emensawerbeseite.gericht_hat_allergenen (code);

create index gericht_id
    on emensawerbeseite.gericht_hat_allergenen (gericht_id);

