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
   id int primary key,
   street varchar2(250),
   city varchar2(250),
   state varchar2(2),
   zip varchar2(5),
   phone varchar2(15),
   fax varchar2(15),
   manager int refrences Manager(id)
);

create table Manager(
   id int refrences employee,
   bonus number(*,2)
);

create table Employee(
   id int primary key,
   firstName varchar2(100),
   lastName varchar2(100),
   sex char,
   birthday Date,
   salary number(*,2),
   branch int refrences Branch(id)
);

create table Supervisor(
   id int refrences Employee
);

create table Associate(
   id int refrences Employee,
   supervisor int refrences Supervisor(id),
   constraint check ( count(select s.id from Supervisor as s where s.id = id) <= 6 )
);

create table Client(
   id int primary key,
   firstName varchar2(100),
   lastName varchar2(100),
   street varchar2(250),
   city varchar2(250),
   state varchar2(2),
   zip varchar2(5),
   phone varchar2(15),
   workPhone varchar2(15),
   propertyType int,
   maxRent number(*,2)
   associate int refrences Associate(id),
   registerDate Date,
   branchId int refrences Branch(id)
);

create table Viewing(
   id int primary key,
   client refrences client(id),
   associate int refrences Associate(id),
   propertyId int refrences Property(id),
   viewDate date,
   comments varchar2(5000)
);

/* Might need to adjust rent, depending on adaptive rent service */
create table Property(
   id int primary key,
   street varchar2(250),
   city varchar2(250),
   state varchar2(2),
   zip varchar2(5),
   type int,
   bedrooms int (3,1),
   bathrooms number(3,1),
   sqFoot number(*,2),
   rent number(*,2),
   fee number(2,5),
   rented char(1),
   lastUpdate date,
   maxRent number(*,2),
   minRent number(*,2),
   associate int refrences Associate(id),
   owner int refrences Owner(id),
   constraint check_boolean check (rented in ('Y', 'N')),
   constraint check_associate check ( count(select a.id from Associate as a where a.id = associate) <= 30 )
);

/* Duration is derived from endDate - startDate */
create table Lease(
   id int primary key,
   rent number(*,2),
   deposit number(*,2),
   startDate date,
   endDate date,
   client int refrences client(id),
   property int refrences Propery(id),
   associate int refrences Associate(id)
);

create table Owner(
   id int primary key,
   name varchar2(100),
   street varchar2(250),
   city varchar2(250),
   state varchar2(2),
   zip varchar2(5),
   phone varchar2(15),
   fax varchar2(15),
   isBusiness char(1).
   constraint check_boolean check (isBusiness in ('Y', 'N'))
);

create table Business(
   id int refrences Owner,
   type varchar2(100),
   contactName varchar2(100)
);

create table Advertisement(
   property int refrences Property(id),
   printDate date,
   cost number(*,2),
   newspaperId int refrences Newspaper(id)
);

create table Newspaper(
   id int primary key,
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





