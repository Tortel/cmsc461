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

create or replace trigger adaptiverentDecrease
   after insert or update on Viewing
   BEGIN
      IF('select count(viewing.id) from viewing, property where propertyId = :NEW.propertyId and viewDate > lastUpdate' <
   'select avg(count(viewing.id)) from viewing, property where viewing.propertyid = property.id and type = :NEW.type and zip = :NEW.zip and viewdate > lastUpdate group by viewing.propertyid') THEN
          UPDATE property SET rent = 0.95*rent WHERE id = :NEW.propertyId;
      update property set rent = minRent if rent < minRent;
   END;
/

/*
      update (Select rent from Property as P where (select count(viewing.id) from viewing where (propertyId = P.id and viewDate > P.lastupdate) < select avg(count(viewing.id)) from viewing, property where propertyid = property.id and viewdate > lastUpdate group by viewing.propertyid ) ) set rent = 0.95*rent; 
      
Select id from Property as P where (select count(viewing.id) from viewing, property where propertyId = P.propertyId and viewDate > P.lastUpdate) < (select avg(count(viewing.id)) from viewing, property where viewing.propertyid = property.id and viewdate > lastUpdate)
      
      IF('select count(viewing.id) from viewing, property where propertyId = :NEW.propertyId and viewDate > lastUpdate' <
   'select avg(count(viewing.id)) from viewing, property where viewing.propertyid = property.id and type = :NEW.type and zip = :NEW.zip and viewdate > lastUpdate group by viewing.propertyid') THEN
          UPDATE property SET rent = 0.95*rent WHERE id = :NEW.propertyId;
      */
