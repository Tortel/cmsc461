/* Drop the tables to make sure its clean */

/* First, need to clear constraints */
alter table Branch drop constraint branch_fk1;
alter table Manager drop constraint manager_fk1;
alter table Employee drop constraint emp_fk1;
alter table Supervisor drop constraint super_fk1;
alter table Associate drop constraint assoc_fk1;
alter table Associate drop constraint assoc_fk2;
alter table Client drop constraint client_fk1;
alter table Client drop constraint client_fk2;
alter table Viewing drop constraint view_fk1;
alter table Viewing drop constraint view_fk2;
alter table Viewing drop constraint view_fk3;
alter table Property drop constraint prop_fk1;
alter table Property drop constraint prop_fk2;
alter table Lease drop constraint lease_fk1;
alter table Lease drop constraint lease_fk2;
alter table Lease drop constraint lease_fk3;
alter table Business drop constraint business_fk1;
alter table Advertisement drop constraint ad_fk1;
alter table Advertisement drop constraint ad_fk2;

/* Nuke the tables */
drop table Branch purge;
drop table Manager purge;
drop table Employee purge;
drop table Supervisor purge;
drop table Associate purge;
drop table Client purge;
drop table Viewing purge;
drop table Property purge;
drop table Lease purge;
drop table Owner purge;
drop table Business purge;
drop table Advertisement purge;
drop table Newspaper purge;


/* Create all the tables that were going to use */

create table Branch(
   id number(10) primary key,
   street varchar2(250) not null,
   city varchar2(250) not null,
   state varchar2(2) not null,
   zip varchar2(5) not null,
   phone varchar2(10) not null,
   fax varchar2(10) not null,
   manager number(10) not null
);

/* Add a default branch */
insert into Branch (id, street, city, state, zip, phone, fax, manager) values
   (0, '123 Main Street', 'Baltimore', 'MD', '21250', '4100000000', '4100000000', 0);


create table Manager(
   id number(10) unique,
   begin date not null,
   bonus number(*,2)
);

/* Add a default manager */
insert into Manager (id, begin, bonus) values (0, CURRENT_DATE, 100);

create table Employee(
   id number(10) primary key,
   firstName varchar2(100) not null,
   lastName varchar2(100) not null,
   sex varchar2(1) not null,
   birthday Date not null,
   street varchar2(250) not null,
   city varchar2(250) not null,
   state varchar2(2) not null,
   zip varchar2(5) not null,
   salary number(*,2) not null,
   branch number(10) not null
);

/* And a default employee */
insert into Employee (id, firstName, lastName, sex, birthday, street, city, state, zip, salary, branch) values
   (0, 'Default', 'Employee', 'M', CURRENT_DATE, '123 Main Street', 'Baltimore', 'MD', '21250', 100, 0);

create table Supervisor(
   id number(10) unique not null
);

create table Associate(
   id number(10) unique not null,
   supervisor number(10)
);

create table Client(
   id number(10) primary key,
   firstName varchar2(100) not null,
   lastName varchar2(100) not null,
   street varchar2(250) not null,
   city varchar2(250) not null,
   state varchar2(2) not null,
   zip varchar2(5) not null,
   phone varchar2(10) not null,
   workphone varchar2(10) not null,
   propertyType number(10) not null,
   maxRent number(*,2) not null,
   associate number(10) not null,
   registerDate Date not null,
   branch number(10) not null
);

create table Viewing(
   id number(10) primary key,
   client number(10) not null,
   associate number(10) not null,
   propertyId number(10) not null,
   viewDate date not null,
   comments varchar2(4000)
);

/* Might need to adjust rent, depending on adaptive rent service */
create table Property(
   id number(10) primary key,
   street varchar2(250) not null,
   city varchar2(250) not null,
   state varchar2(2) not null,
   zip varchar2(5) not null,
   type number(10) not null,
   bedrooms number(10,1) not null,
   bathrooms number(10,1) not null,
   sqFoot number(*,2) not null,
   rent number(*,2) not null,
   fee decimal(10,5) not null,
   rented char(1) not null,
   posted date not null,
   lastUpdate date not null,
   maxRent number(*,2) not null,
   minRent number(*,2) not null,
   associate number(10) not null,
   owner number(10) not null,
   constraint boolean_prop check (rented in ('Y', 'N'))
);

/* Duration is derived from endDate - startDate */
create table Lease(
   id number(10) primary key,
   rent number(*,2) not null,
   deposit number(*,2) not null,
   startDate date not null,
   endDate date not null,
   client number(10) not null,
   property number(10) not null,
   associate number(10) not null
);

create table Owner(
   id number(10) primary key,
   name varchar2(100) not null,
   street varchar2(250) not null,
   city varchar2(250) not null,
   state varchar2(2) not null,
   zip varchar2(5) not null,
   phone varchar2(10) not null,
   fax varchar2(10) not null,
   isBusiness char(1) not null,
   constraint boolean_owner check (isBusiness in ('Y', 'N'))
);

create table Business(
   id number(10) not null,
   type varchar2(100) not null,
   contactName varchar2(100) not null
);

create table Advertisement(
   id number(10) primary key,
   property number(10) not null,
   printDate date not null,
   cost number(*,2) not null,
   newspaperId number(10) not null
);

create table Newspaper(
   id number(10) primary key,
   name varchar2(100) not null,
   street varchar2(250) not null,
   city varchar2(250) not null,
   state varchar2(2) not null,
   zip varchar2(5) not null,
   phone varchar2(10) not null,
   fax varchar2(10) not null,
   contactName varchar2(100) not null
);


/* Add in all the foreign key stuff, because it doesnt work until the tables are there */
alter table Branch add constraint branch_fk1 foreign key(manager) REFERENCES Manager(id);

alter table Manager add constraint manager_fk1 foreign key(id) REFERENCES Employee(id);

alter table Employee add constraint emp_fk1 foreign key(branch) REFERENCES Branch(id);

alter table Supervisor add constraint super_fk1 foreign key(id) REFERENCES Employee(id);

alter table Associate add constraint assoc_fk1 foreign key(id) REFERENCES Employee(id);
alter table Associate add constraint assoc_fk2 foreign key(supervisor) REFERENCES Supervisor(id);

alter table Client add constraint client_fk1 foreign key(branch) REFERENCES Branch(id);
alter table Client add constraint client_fk2 foreign key(associate) REFERENCES Associate(id);

alter table Viewing add constraint view_fk1 foreign key(client) REFERENCES Client(id);
alter table Viewing add constraint view_fk2 foreign key(associate) REFERENCES Associate(id);
alter table Viewing add constraint view_fk3 foreign key(propertyId) REFERENCES Property(id);

alter table Property add constraint prop_fk1 foreign key(associate) REFERENCES Associate(id);
alter table Property add constraint prop_fk2 foreign key(owner) REFERENCES Owner(id);

alter table Lease add constraint lease_fk1 foreign key(client) REFERENCES Client(id);
alter table Lease add constraint lease_fk2 foreign key(property) REFERENCES Property(id);
alter table Lease add constraint lease_fk3 foreign key(associate) REFERENCES Associate(id);

alter table Business add constraint business_fk1 foreign key(id) REFERENCES Owner(id);

alter table Advertisement add constraint ad_fk1 foreign key(newspaperId) REFERENCES Newspaper(id);
alter table Advertisement add constraint ad_fk2 foreign key(property) REFERENCES Property(id);

/* Need a function to calculate the average popularity since a given date */

create or replace trigger check_supervisor
   before insert or update on Associate
   REFERENCING NEW as newRow
   for each row
   BEGIN
      if( ':NEW.supervisor' is not null ) then
         if( 'count( select Associate.supervisor into x from Associate where Associate.supervisor = :NEW.supervisor )' > '12' ) then
            RAISE_APPLICATION_ERROR(-20000, 'Supervisor can only supervise 12 associates');
         end if;
      end if;
   EXCEPTION
      when VALUE_ERROR then
         dbms_output.put_line('Value_error raised');
   END;
/

create or replace trigger check_associate
   before insert or update on Property
   REFERENCING NEW as newRow
   for each row
   BEGIN
      if( ':NEW.associate' is not null ) then
         if( 'count( select Property.associate into x from Property where Property.associate = :NEW.associate )' > '30') then
            RAISE_APPLICATION_ERROR(-20000, 'Associate can only manage 30 properties');
         end if;
      end if;
   END;
/


create or replace trigger mark_rented
   before insert or update on Lease
   for each row
   BEGIN
      update property set rented = 'Y' where id = :NEW.property;
   END;
/

create or replace trigger mark_unrented
   before delete on Lease
   for each row
   BEGIN
      update property set rented = 'N' where id = :OLD.property;
   END;
/

create or replace trigger delete_manager
   after delete on Branch
   for each row
   BEGIN
      delete from Manager where Manager.id = :OLD.manager;
   END;
/

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

create or replace trigger checkViewing
   before insert or update on Viewing
   for each row
   BEGIN
      if('select count(id) from viewing where client = :NEW.client and propertyId = :NEW.propertyId and viewDate = :NEW.viewDate' > '0') then
         RAISE_APPLICATION_ERROR(-20000, 'Can only view a property once per day');
      end if;
   END;
/

/* No freaking auto-increment primary key? Are you kidding? */
drop sequence key_branch;
CREATE SEQUENCE key_branch
MINVALUE 10
START WITH 10
INCREMENT BY 1;

drop sequence key_employee;
CREATE SEQUENCE key_employee
MINVALUE 10
START WITH 20
INCREMENT BY 1;

drop sequence key_client;
CREATE SEQUENCE key_client
MINVALUE 1
START WITH 25
INCREMENT BY 1;

drop sequence key_viewing;
CREATE SEQUENCE key_viewing
MINVALUE 1
START WITH 10
INCREMENT BY 1;

drop sequence key_property;
CREATE SEQUENCE key_property
MINVALUE 1
START WITH 30
INCREMENT BY 1;

drop sequence key_lease;
CREATE SEQUENCE key_lease
MINVALUE 1
START WITH 15
INCREMENT BY 1;

drop sequence key_owner;
CREATE SEQUENCE key_owner
MINVALUE 1
START WITH 15
INCREMENT BY 1;

drop sequence key_newspaper;
CREATE SEQUENCE key_newspaper
MINVALUE 1
START WITH 10
INCREMENT BY 1;

drop sequence key_ad;
CREATE SEQUENCE key_ad
MINVALUE 1
START WITH 1
INCREMENT BY 1;

