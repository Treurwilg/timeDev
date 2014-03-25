delimiter $$
create trigger tTijdregelCheckTijd_bi 
before insert on Tijdregel
for each row
begin
  declare msg varchar(255);
  if new.tijd > 24.0 or new.tijd <= 0 then
    set msg := 'Foute invoer: tijd moet > 0 en <= 24 zijn ';
      signal sqlstate '45000' set message_text = msg;
  end if;
end$$
delimiter ;
