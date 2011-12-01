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
   foreign key(manager) refrences Manager(id)
);

create table Manager(
   id number(10),
   bonus number(*,2),
   foreign key (id) refrences Employee(id)
);

create table Employee(
   id number(10) primary key,
   firstName varchar2(100),
   lastName varchar2(100),
   sex char,
   birthday Date,
   salary number(*,2),
   branch number(10),
   foreign key (branch) refrences Branch(id)
);

create table Supervisor(
   id number(10),
   foreign key (id) refrences Employee(id)
);

create table Associate(
   id number(10),
   supervisor number(10),
   foreign key (id) refrences Employee(id),
   foreign key (supervisor) refrences Supervisor(id),
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
   foreign key (branchId) refrences Branch(id),
   foreign key (associate) refrences Associate(id)
);

create table Viewing(
   id number(10) primary key,
   client number(10),
   associate number(10),
   propertyId number(10),
   viewDate date,
   comments varchar2(4000),
   foreign key (client) refrences Client(id),
   foreign key (associate) refrences Associate(id),
   foreign key (propertyId) refrences Property(id)
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
   foreign key (associate) refrences Associate(id),
   foreign key (owner) refrences Owner(id),
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
   foreign key (client) refrences Client(id),
   foreign key (property) refrences Porperty(id),
   foreign key (associate) refrences Associate(id)
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
   isBusiness char(1).
   constranumber(10) check_boolean check (isBusiness in ('Y', 'N'))
);

create table Business(
   id number(10),
   type varchar2(100),
   contactName varchar2(100),
   foreign key (id) refrences Owner(id)
);

create table Advertisement(
   property number(10),
   prnumber(10)Date date,
   cost number(*,2),
   newspaperId number(10),
   foreign key (newspaperId) refrences Newspaper(id),
   foreign key (property) refrences Property(id)
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





