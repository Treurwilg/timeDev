
create table Fase  -- runs well on xampp_mysql
( code char(3) not null,
  naam varchar(20) not null,
  volgnr smallint(2) not null,
  constraint pk_Fase primary key (code)
)
