
create table Type  -- runs well on xampp_mysql
( code char(2) not null,
  omschrijving varchar(20),
  startnr smallint(3) not null,
  eindnr smallint(3) not null,
  constraint pk_Type primary key (code)
  )
