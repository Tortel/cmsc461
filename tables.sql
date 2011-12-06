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
   street varchar2(250),
   city varchar2(250),
   state varchar2(2),
   zip varchar2(5),
   phone varchar2(10),
   fax varchar2(10),
   manager number(10)
);

create table Manager(
   id number(10) unique,
   begin date,
   bonus number(*,2)
);

create table Employee(
   id number(10) primary key,
   firstName varchar2(100),
   lastName varchar2(100),
   sex varchar2(1),
   birthday Date,
   street varchar2(250),
   city varchar2(250),
   state varchar2(2),
   zip varchar2(5),
   salary number(*,2),
   branch number(10)
);

create table Supervisor(
   id number(10) unique
);

create table Associate(
   id number(10) unique,
   supervisor number(10)
);

create table Client(
   id number(10) primary key,
   firstName varchar2(100),
   lastName varchar2(100),
   street varchar2(250),
   city varchar2(250),
   state varchar2(2),
   zip varchar2(5),
   phone varchar2(10),
   workphone varchar2(10),
   propertyType number(10),
   maxRent number(*,2),
   associate number(10),
   registerDate Date,
   branchId number(10)
);

create table Viewing(
   id number(10) primary key,
   client number(10),
   associate number(10),
   propertyId number(10),
   viewDate date,
   comments varchar2(4000)
);

/* Might need to adjust rent, depending on adaptive rent service */
create table Property(
   id number(10) primary key,
   street varchar2(250),
   city varchar2(250),
   state varchar2(2),
   zip varchar2(5),
   type number(10),
   bedrooms number(3,1),
   bathrooms number(3,1),
   sqFoot number(*,2),
   rent number(*,2),
   fee number(2,5),
   rented char(1),
   lastUpdate date,
   maxRent number(*,2),
   minRent number(*,2),
   associate number(10),
   owner number(10),
   constraint boolean_prop check (rented in ('Y', 'N'))
);

/* Duration is derived from endDate - startDate */
create table Lease(
   id number(10) primary key,
   rent number(*,2),
   deposit number(*,2),
   startDate date,
   endDate date,
   client number(10),
   property number(10),
   associate number(10)
);

create table Owner(
   id number(10) primary key,
   name varchar2(100),
   street varchar2(250),
   city varchar2(250),
   state varchar2(2),
   zip varchar2(5),
   phone varchar2(10),
   fax varchar2(10),
   isBusiness char(1),
   constraint boolean_owner check (isBusiness in ('Y', 'N'))
);

create table Business(
   id number(10),
   type varchar2(100),
   contactName varchar2(100)
);

create table Advertisement(
   property number(10),
   printDate date,
   cost number(*,2),
   newspaperId number(10)
);

create table Newspaper(
   id number(10) primary key,
   name varchar2(100),
   street varchar2(250),
   city varchar2(250),
   state varchar2(2),
   zip varchar2(5),
   phone varchar2(10),
   fax varchar2(10),
   contactName varchar2(100)
);


/* Add in all the foreign key stuff, because it doesnt work until the tables are there */
alter table Branch add constraint branch_fk1 foreign key(manager) REFERENCES Manager(id) on delete CASCADE;

alter table Manager add constraint manager_fk1 foreign key(id) REFERENCES Employee(id);

alter table Employee add constraint emp_fk1 foreign key(branch) REFERENCES Branch(id);

alter table Supervisor add constraint super_fk1 foreign key(id) REFERENCES Employee(id);

alter table Associate add constraint assoc_fk1 foreign key(id) REFERENCES Employee(id);
alter table Associate add constraint assoc_fk2 foreign key(supervisor) REFERENCES Supervisor(id);

alter table Client add constraint client_fk1 foreign key(branchId) REFERENCES Branch(id);
alter table Client add constraint client_fk2 foreign key(associate) REFERENCES Associate(id);

alter table Viewing add constraint view_fk1 foreign key(client) REFERENCES Client(id);
alter table Viewing add constraint view_fk2 foreign key(associate) REFERENCES Associate(id);
alter table Viewing add constraint view_fk3 foreign key(propertyId) REFERENCES Property(id);

alter table Property add constraint prop_fk1 foreign key(associate) REFERENCES Associate(id);
alter table Property add constraint prop_fk2 foreign key(owner) REFERENCES Owner(id);

alter table Lease add constraint lease_fk1 foreign key(client) REFERENCES Client(id);
alter table Lease add constraint lease_fk2 foreign key(property) REFERENCES Property(id);
alter table Lease add constraint lease_fk3 foreign key(associate) REFERENCES Associate(id);

alter table Business add constraint business_fk1 foreign key(id) REFERENCES Owner(id) on delete CASCADE;

alter table Advertisement add constraint ad_fk1 foreign key(newspaperId) REFERENCES Newspaper(id) on delete CASCADE;
alter table Advertisement add constraint ad_fk2 foreign key(property) REFERENCES Property(id) on delete CASCADE;

/* Need a function to calculate the average popularity since a given date */

/*
Needs to be a trigger:
constraint) check_associate ( count(select s.id from Supervisor as s where s.id = id) <= 6 )
*/


create or replace trigger check_supervisor
   before insert or update on Associate
   REFERENCING NEW as newRow
   for each row
   BEGIN
      if( 'NEW.supervisor' is not null ) then
         if( 'count( select Associate.supervisor into x from Associate where Associate.supervisor = NEW.supervisor )' > 6 ) then
            RAISE_APPLICATION_ERROR(-20000, 'Supervisor can only supervise 6 associates');
         end if;
      end if;
   END;
/


/*
Needs to be a trigger:
constraint check_ check ( count(select a.id from Associate as a where a.id = associate) <= 30 )
*/

create or replace trigger check_associate
   before insert or update on Property
   REFERENCING NEW as newRow
   for each row
   BEGIN
      if( 'NEW.associate' is not null ) then
         if( 'count( select Property.associate into x from Property where Property.associate = NEW.associate )' > 30) then
            RAISE_APPLICATION_ERROR(-20000, 'Associate can only manage 30 properties');
         end if;
      end if;
   END;
/


/* Grants for my DB user (cmsc461) */

/*
grant All on LEASE to CMSC461;
grant All on Branch to CMSC461;
grant All on Manager to CMSC461;
grant All on Employee to CMSC461;
grant All on Supervisor to CMSC461;
grant All on Associate to CMSC461;
grant All on Client to CMSC461;
grant All on Viewing to CMSC461;
grant All on Property to CMSC461;
grant All on Lease to CMSC461;
grant All on Owner to CMSC461;
grant All on Business to CMSC461;
grant All on Advertisement to CMSC461;
grant All on Newspaper to CMSC461;
*/

/* No freaking auto-increment primary key? Are you kidding? */
CREATE SEQUENCE key_branch
MINVALUE 1
START WITH 1
INCREMENT BY 1;

CREATE SEQUENCE key_employee
MINVALUE 1
START WITH 1
INCREMENT BY 1;

CREATE SEQUENCE key_client
MINVALUE 1
START WITH 1
INCREMENT BY 1;

CREATE SEQUENCE key_viewing
MINVALUE 1
START WITH 1
INCREMENT BY 1;

CREATE SEQUENCE key_property
MINVALUE 1
START WITH 1
INCREMENT BY 1;

CREATE SEQUENCE key_lease
MINVALUE 1
START WITH 1
INCREMENT BY 1;

CREATE SEQUENCE key_owner
MINVALUE 1
START WITH 1
INCREMENT BY 1;

CREATE SEQUENCE key_newspaper
MINVALUE 1
START WITH 1
INCREMENT BY 1;


