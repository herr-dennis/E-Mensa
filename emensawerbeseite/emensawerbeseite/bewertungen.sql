create table emensawerbeseite.bewertungen
(
    benutzerID          bigint                                null,
    gerichtsID          bigint                                null,
    bewertungstext      varchar(500)                          null,
    sterne              bigint                                null,
    bewertungszeitpunkt timestamp default current_timestamp() null,
    bewertungID         bigint auto_increment
        primary key,
    constraint bewertungen_ibfk_1
        foreign key (benutzerID) references emensawerbeseite.benutzer (id),
    constraint bewertungen_ibfk_2
        foreign key (gerichtsID) references emensawerbeseite.gericht (id)
);

create index benutzerID
    on emensawerbeseite.bewertungen (benutzerID);

create index gerichtsID
    on emensawerbeseite.bewertungen (gerichtsID);

