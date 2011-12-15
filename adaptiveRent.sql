/* Adaptive Rent Service */
create or replace trigger adaptiveRentIncrease
   before insert or update on Viewing
   for each row
   BEGIN
      if('select count(viewing.id) from viewing, property where propertyId = :NEW.propertyId and viewDate > lastUpdate' > 'select avg(count(viewing.id)) from viewing, property where viewing.propertyid = property.id and type = :NEW.type and zip = :NEW.zip and viewdate > lastUpdate group by viewing.propertyid') then
         update property set rent = 1.05*rent where id = :NEW.propertyId;
         update property set rent = maxrent where rent > maxrent;
      end if;
   END;
/

