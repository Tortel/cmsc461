/* Create all the tables that were going to use */

create table Branch(
   id int primary key,
   street varchar(250),
   city varchar(250),
   state varchar(25),
   zip varchar(5),
   phone varchar(15),
   fax varchar(15),
   manager refrences Manager(id)
);

create table Manager(
   id refrences employee,
   bonus number(*,2)
);

create table Employee(
   id int primary key,
   firstName varchar(100),
   lastName varchar(100),
   sex char,
   birthday Date,
   salary number(*,2),
   branch refrences Branch(id)
);

create table Supervisor(
   id refrences Employee
);

create table Associate(
   id refrences Employee,
   supervisor refrences Supervisor(id),
   constraint check ( count(select s.id from Supervisor as s where s.id = id) <= 6 )
);

create table Client(
   id int primary key,
   firstName varchar(100),
   lastName varchar(100),
   street varchar(250),
   city varchar(250),
   state varchar(25),
   zip varchar(5),
   phone varchar(15),
   workPhone varchar(15),
   propertyType int,
   maxRent number(*,2)
   associate refrences Associate(id),
   registerDate Date,
   branchId refrences Branch(id)
);

create table Viewing(
   id int primary key,
   client refrences client(id),
   associate refrences Associate(id),
   propertyId refrences Property(id),
   viewDate date,
   comments varchar(5000)
);

/* Might need to adjust rent, depending on adaptive rent service */
create table Property(
   id int primary key,
   street varchar(250),
   city varchar(250),
   state varchar(25),
   zip varchar(5),
   type int,
   bedrooms int (3,1),
   bathrooms number(3,1),
   sqFoot number(*,2),
   rent number(*,2),
   fee number(2,5),
   rented char(1),
   associate refrences Associate(id),
   owner refrences Owner(id),
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
   client refrences client(id),
   property refrences Propery(id),
   associate refrences Associate(id)
);

create table Owner(
   id int primary key,
   name varchar(100),
   street varchar(250),
   city varchar(250),
   state varchar(25),
   zip varchar(5),
   phone varchar(15),
   fax varchar(15),
   isBusiness char(1).
   constraint check_boolean check (isBusiness in ('Y', 'N'))
);

create table Business(
   id refrences Owner,
   type varchar(100),
   contactName varchar(100)
);

create table Advertisement(
   property refrences Property(id),
   printDate date,
   cost number(*,2),
   newspaperId refrences Newspaper(id)
);

create table Newspaper(
   id int primary key,
   name varchar(100),
   street varchar(250),
   city varchar(250),
   state varchar(25),
   zip varchar(5),
   phone varchar(15),
   fax varchar(15),
   contactName varchar(100)
);
