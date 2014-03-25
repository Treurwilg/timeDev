create table Project  -- runs well on xampp_mysql
(
nr smallint(3) not null,
naam varchar(25) not null,
opdrachtgever varchar(25) not null,
type char(2) not null,
geplandeStart date not null,
geplandEind date not null,
actueleStart date,
actueelEind date,
beschrijving varchar(250) not null,
constraint pk_Project primary key (nr),
constraint fk_Project_Type foreign key(type) references Type(code)
)