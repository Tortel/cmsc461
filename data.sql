/* Disable FKs between branch/manager */
alter table Branch disable constraint branch_fk1;

/* 5 Branches, 3 states 
 * 
 * Per branch:
 * 3 employees
 * 2 Owners
 * 5 Properties
 * 4 Clients
 * 2 Leases
 * 1 Advertisement
 * 1 Viewing
 */

/* Branch 1 */
insert into Branch (id, street, city, state, zip, phone, fax, manager) values
   (1, '402 W Locust St', 'Normal', 'IL', '61761', '4100000000', '4100000000', 1);

/* Employees */
insert into Employee (id, firstName, lastName, sex, birthday, street, city, state, zip, salary, branch) values
   (1, 'Illinois', 'Manager', 'M', CURRENT_DATE, '123 Main Street', 'Normal', 'IL', '61761', 70000, 1);
insert into Employee (id, firstName, lastName, sex, birthday, street, city, state, zip, salary, branch) values
   (2, 'Illinois', 'Supervisor', 'M', CURRENT_DATE, '123 Main Street', 'Normal', 'IL', '61761', 70000, 1);
insert into Employee (id, firstName, lastName, sex, birthday, street, city, state, zip, salary, branch) values
   (3, 'Illinois', 'Associate', 'M', CURRENT_DATE, '123 Main Street', 'Normal', 'IL', '61761', 70000, 1);

/* Give them positions */
insert into Manager (id, begin, bonus) values (1, CURRENT_DATE, 500);
insert into Supervisor (id) values (2);
insert into Associate (id, supervisor) values (3, 2);

/* Owners */
insert into Owner (id, name, street, city, state, zip, phone, fax, isBusiness) values
   (1, 'IL Private Owner', '543 West Street', 'Normal', 'IL', '61761', '4100000000', '4100000000', 'N');
insert into Owner (id, name, street, city, state, zip, phone, fax, isBusiness) values
   (2, 'IL Business Owner', '345 East Street', 'Normal', 'IL', '61761', '4100000000', '4100000000', 'Y');
insert into Business (id, type, contactName) values
   (2, 'Apartment Business', 'Person McContact');

/* Properties */


/* Re-enable the FKs */
alter table Branch enable constraint branch_fk1;
