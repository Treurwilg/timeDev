create table Tijdregel
( nr int not null auto_increment,
  datumtijd timestamp not null default now(), -- lukt niet met date en curdate())
  project smallint(3) not null,
  fase char(3) not null,
  tijd decimal(3,1) not null, 
  opmerking varchar(50),
  constraint pk_Tijdregel primary key(nr),
  constraint fk_Tijdregel_Project foreign key(project) references Project(nr),
  constraint fk_Tijdregel_Fase foreign key(fase) references Fase(code)
)
