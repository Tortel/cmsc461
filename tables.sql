/* Drop the tables to make sure its clean */

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
   phone varchar2(15),
   fax varchar2(15),
   manager number(10),
   constraint branch_fk1 foreign key(manager) REFERENCES Manager(id)
);

create table Manager(
   id number(10),
   bonus number(*,2),
   constraint manager_fk1 foreign key(id) REFERENCES Employee(id)
);

create table Employee(
   id number(10) primary key,
   firstName varchar2(100),
   lastName varchar2(100),
   sex char,
   birthday Date,
   salary number(*,2),
   branch number(10),
   constraint emp_fk1 foreign key(branch) REFERENCES Branch(id)
);

create table Supervisor(
   id number(10),
   constraint super_fk1 foreign key(id) REFERENCES Employee(id)
);

create table Associate(
   id number(10),
   supervisor number(10),
   constraint assoc_fk1 foreign key(id) REFERENCES Employee(id),
   constraint assoc_fk2 foreign key(supervisor) REFERENCES Supervisor(id),
   constranumber(10) check ( count(select s.id from Supervisor as s where s.id = id) <= 6 )
);

create table Client(
   id number(10) primary key,
   firstName varchar2(100),
   lastName varchar2(100),
   street varchar2(250),
   city varchar2(250),
   state varchar2(2),
   zip varchar2(5),
   phone varchar2(15),
   workPhone varchar2(15),
   propertyType number(10),
   maxRent number(*,2)
   associate number(10),
   registerDate Date,
   branchId number(10),
   constraint client_fk1 foreign key(branchId) REFERENCES Branch(id),
   constraint client_fk2 foreign key(associate) REFERENCES Associate(id)
);

create table Viewing(
   id number(10) primary key,
   client number(10),
   associate number(10),
   propertyId number(10),
   viewDate date,
   comments varchar2(4000),
   constraint view_fk1 foreign key(client) REFERENCES Client(id),
   constraint view_fk2 foreign key(associate) REFERENCES Associate(id),
   constraint view_fk3 foreign key(propertyId) REFERENCES Property(id)
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
   constraint prop_fk1 foreign key(associate) REFERENCES Associate(id),
   constraint prop_fk2 foreign key(owner) REFERENCES Owner(id),
   constranumber(10) check_boolean check (rented in ('Y', 'N')),
   constranumber(10) check_associate check ( count(select a.id from Associate as a where a.id = associate) <= 30 )
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
   associate number(10),
   constraint lease_fk1 foreign key(client) REFERENCES Client(id),
   constraint lease_fk2 foreign key(property) REFERENCES Porperty(id),
   constraint lease_fk3 foreign key(associate) REFERENCES Associate(id)
);

create table Owner(
   id number(10) primary key,
   name varchar2(100),
   street varchar2(250),
   city varchar2(250),
   state varchar2(2),
   zip varchar2(5),
   phone varchar2(15),
   fax varchar2(15),
   isBusiness char(1),
   constranumber(10) check_boolean check (isBusiness in ('Y', 'N'))
);

create table Business(
   id number(10),
   type varchar2(100),
   contactName varchar2(100),
   constraint business_fk1 foreign key(id) REFERENCES Owner(id)
);

create table Advertisement(
   property number(10),
   printDate date,
   cost number(*,2),
   newspaperId number(10),
   constraint ad_fk1 foreign key(newspaperId) REFERENCES Newspaper(id),
   constraint ad_fk2 foreign key(property) REFERENCES Property(id)
);

create table Newspaper(
   id number(10) primary key,
   name varchar2(100),
   street varchar2(250),
   city varchar2(250),
   state varchar2(2),
   zip varchar2(5),
   phone varchar2(15),
   fax varchar2(15),
   contactName varchar2(100)
);

/* Need a function to calculate the average popularity since a given date */





