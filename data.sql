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

/* Branch 1 - Normal, IL */
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
insert into Property (id, street, city, state, zip, type, bedrooms, bathrooms, sqFoot, rent, fee, rented, posted, lastupdate, minRent, maxRent, associate, owner) values
   (1, '403 W Locust St', 'Normal', 'IL', '61761', 0, 2, 2, 700, 900, 13, 'N', TO_DATE('11.15.2010', 'MM.DD.YYYY'), CURRENT_DATE, 700, 1100, 3, 1);
insert into Property (id, street, city, state, zip, type, bedrooms, bathrooms, sqFoot, rent, fee, rented, posted, lastupdate, minRent, maxRent, associate, owner) values
   (2, '404 W Locust St', 'Normal', 'IL', '61761', 1, 4, 3, 1300, 1000, 11, 'N', TO_DATE('11.15.2010', 'MM.DD.YYYY'), CURRENT_DATE, 900, 1300, 3, 2);
insert into Property (id, street, city, state, zip, type, bedrooms, bathrooms, sqFoot, rent, fee, rented, posted, lastupdate, minRent, maxRent, associate, owner) values
   (3, '405 E Locust St', 'Normal', 'IL', '61761', 2, 5, 4, 2500, 1700, 10, 'Y', TO_DATE('11.15.2010', 'MM.DD.YYYY'), CURRENT_DATE, 1700, 300, 3, 1);
insert into Property (id, street, city, state, zip, type, bedrooms, bathrooms, sqFoot, rent, fee, rented, posted, lastupdate, minRent, maxRent, associate, owner) values
   (4, '406 E Locust St', 'Normal', 'IL', '61761', 1, 3, 3, 1200, 900, 11, 'N', TO_DATE('11.15.2010', 'MM.DD.YYYY'), CURRENT_DATE, 900, 1400, 3, 2);
insert into Property (id, street, city, state, zip, type, bedrooms, bathrooms, sqFoot, rent, fee, rented, posted, lastupdate, minRent, maxRent, associate, owner) values
   (5, '407 S Locust St', 'Normal', 'IL', '61761', 0, 1, 1, 500, 600, 15, 'N', TO_DATE('11.15.2010', 'MM.DD.YYYY'), CURRENT_DATE, 500, 800, 3, 1);

/* Clients */
insert into Client (id, street, city, state, zip, firstname, lastName, branch, phone, workPhone, propertyType, maxRent, associate, registerDate) values
   (1, '200 W Locust St', 'Normal', 'IL', '61761', 'Client 1', 'Illinois', 1, '4100000000', '4100000000', 0, 1500, 3, CURRENT_DATE);
insert into Client (id, street, city, state, zip, firstname, lastName, branch, phone, workPhone, propertyType, maxRent, associate, registerDate) values
   (2, '201 W Locust St', 'Normal', 'IL', '61761', 'Client 2', 'Illinois', 1, '4100000000', '4100000000', 1, 1200, 3, CURRENT_DATE);
insert into Client (id, street, city, state, zip, firstname, lastName, branch, phone, workPhone, propertyType, maxRent, associate, registerDate) values
   (3, '202 W Locust St', 'Normal', 'IL', '61761', 'Client 3', 'Illinois', 1, '4100000000', '4100000000', 2, 900, 3, CURRENT_DATE);
insert into Client (id, street, city, state, zip, firstname, lastName, branch, phone, workPhone, propertyType, maxRent, associate, registerDate) values
   (4, '203 W Locust St', 'Normal', 'IL', '61761', 'Client 4', 'Illinois', 1, '4100000000', '4100000000', 0, 2000, 3, CURRENT_DATE);

/* Leases */
insert into Lease (id, rent, deposit, startDate, endDate, client, property, associate) values
   (1, 900, 100, TO_DATE('12.10.2010', 'MM.DD.YYYY'), TO_DATE('12.10.2011', 'MM.DD.YYYY'), 1, 2, 3);
insert into Lease (id, rent, deposit, startDate, endDate, client, property, associate) values
   (2, 2500, 500, TO_DATE('12.10.2010', 'MM.DD.YYYY'), TO_DATE('12.10.2012', 'MM.DD.YYYY'), 3, 3, 3);

/* Advertisement */
insert into Newspaper (id, street, city, state, zip, name, phone, fax, contactName) values
   (1, '5421 Business Parkway', 'Normal', 'IL', '61761', 'The Post', '4100000000', '4100000000', 'P. Parker');
insert into Advertisement (id, property, printDate, cost, newspaperId) values
   (key_ad.nextval, 4, CURRENT_DATE, 200, 1);

/* Viewing */
insert into viewing (id, client, associate, propertyId, viewDate, comments) values
   (key_viewing.nextval, 2, 3, 1, TO_DATE('11.15.2011', 'MM.DD.YYYY'), 'This is a nice place!');


/* Branch 2 - Baltimore, MD */
insert into Branch (id, street, city, state, zip, phone, fax, manager) values
   (2, '402 W Pratt St', 'Baltimore', 'MD', '21250', '4100000000', '4100000000', 1);

/* Employees */
insert into Employee (id, firstName, lastName, sex, birthday, street, city, state, zip, salary, branch) values
   (4, 'Maryland', 'Manager', 'M', CURRENT_DATE, '123 Main Street', 'Baltimore', 'MD', '21250', 70000, 2);
insert into Employee (id, firstName, lastName, sex, birthday, street, city, state, zip, salary, branch) values
   (5, 'Maryland', 'Supervisor', 'M', CURRENT_DATE, '123 Main Street', 'Baltimore', 'MD', '21250', 70000, 2);
insert into Employee (id, firstName, lastName, sex, birthday, street, city, state, zip, salary, branch) values
   (6, 'Maryland', 'Associate', 'M', CURRENT_DATE, '123 Main Street', 'Baltimore', 'MD', '21250', 70000, 2);

/* Give them positions */
insert into Manager (id, begin, bonus) values (4, CURRENT_DATE, 500);
insert into Supervisor (id) values (5);
insert into Associate (id, supervisor) values (6, 5);

/* Owners */
insert into Owner (id, name, street, city, state, zip, phone, fax, isBusiness) values
   (3, 'MD Private Owner', '543 West Street', 'Baltimore', 'MD', '21250', '4100000000', '4100000000', 'N');
insert into Owner (id, name, street, city, state, zip, phone, fax, isBusiness) values
   (4, 'MD Business Owner', '345 East Street', 'Baltimore', 'MD', '21250', '4100000000', '4100000000', 'Y');
insert into Business (id, type, contactName) values
   (4, 'Apartment Business', 'George Winters');

/* Properties */
insert into Property (id, street, city, state, zip, type, bedrooms, bathrooms, sqFoot, rent, fee, rented, posted, lastupdate, minRent, maxRent, associate, owner) values
   (6, '403 W Pratt St', 'Baltimore', 'MD', '21250', 0, 2, 2, 700, 900, 13, 'N', TO_DATE('11.15.2010', 'MM.DD.YYYY'), CURRENT_DATE, 700, 1100, 6, 4);
insert into Property (id, street, city, state, zip, type, bedrooms, bathrooms, sqFoot, rent, fee, rented, posted, lastupdate, minRent, maxRent, associate, owner) values
   (7, '404 W Pratt St', 'Baltimore', 'MD', '21250', 1, 4, 3, 1300, 1000, 11, 'N', TO_DATE('11.15.2010', 'MM.DD.YYYY'), CURRENT_DATE, 900, 1300, 6, 3);
insert into Property (id, street, city, state, zip, type, bedrooms, bathrooms, sqFoot, rent, fee, rented, posted, lastupdate, minRent, maxRent, associate, owner) values
   (8, '405 E Pratt St', 'Baltimore', 'MD', '21250', 2, 5, 4, 2500, 1700, 10, 'Y', TO_DATE('11.15.2010', 'MM.DD.YYYY'), CURRENT_DATE, 1700, 300, 6, 4);
insert into Property (id, street, city, state, zip, type, bedrooms, bathrooms, sqFoot, rent, fee, rented, posted, lastupdate, minRent, maxRent, associate, owner) values
   (9, '406 E Pratt St', 'Baltimore', 'MD', '21250', 1, 3, 3, 1200, 900, 11, 'N', TO_DATE('11.15.2010', 'MM.DD.YYYY'), CURRENT_DATE, 900, 1400, 6, 3);
insert into Property (id, street, city, state, zip, type, bedrooms, bathrooms, sqFoot, rent, fee, rented, posted, lastupdate, minRent, maxRent, associate, owner) values
   (10, '407 S Pratt St', 'Baltimore', 'MD', '21250', 0, 1, 1, 500, 600, 15, 'N', TO_DATE('11.15.2010', 'MM.DD.YYYY'), CURRENT_DATE, 500, 800, 6, 4);

/* Clients */
insert into Client (id, street, city, state, zip, firstname, lastName, branch, phone, workPhone, propertyType, maxRent, associate, registerDate) values
   (5, '200 W Pratt St', 'Baltimore', 'MD', '21250', 'Client 1', 'Maryland', 2, '4100000000', '4100000000', 0, 1500, 6, CURRENT_DATE);
insert into Client (id, street, city, state, zip, firstname, lastName, branch, phone, workPhone, propertyType, maxRent, associate, registerDate) values
   (6, '201 W Pratt St', 'Baltimore', 'MD', '21250', 'Client 2', 'Maryland', 2, '4100000000', '4100000000', 1, 1200, 6, CURRENT_DATE);
insert into Client (id, street, city, state, zip, firstname, lastName, branch, phone, workPhone, propertyType, maxRent, associate, registerDate) values
   (7, '202 W Pratt St', 'Baltimore', 'MD', '21250', 'Client 3', 'Maryland', 2, '4100000000', '4100000000', 2, 900, 6, CURRENT_DATE);
insert into Client (id, street, city, state, zip, firstname, lastName, branch, phone, workPhone, propertyType, maxRent, associate, registerDate) values
   (8, '203 W Pratt St', 'Baltimore', 'MD', '21250', 'Client 4', 'Maryland', 2, '4100000000', '4100000000', 0, 2000, 6, CURRENT_DATE);

/* Leases */
insert into Lease (id, rent, deposit, startDate, endDate, client, property, associate) values
   (3, 900, 100, TO_DATE('12.10.2010', 'MM.DD.YYYY'), TO_DATE('12.10.2011', 'MM.DD.YYYY'), 5, 7, 6);
insert into Lease (id, rent, deposit, startDate, endDate, client, property, associate) values
   (4, 2500, 500, TO_DATE('12.10.2010', 'MM.DD.YYYY'), TO_DATE('12.10.2012', 'MM.DD.YYYY'), 7, 8, 6);

/* Advertisement */
insert into Newspaper (id, street, city, state, zip, name, phone, fax, contactName) values
   (2, '5421 Business Parkway', 'Baltimore', 'MD', '21250', 'The Sun', '4100000000', '4100000000', 'J Jameson');
insert into Advertisement (id, property, printDate, cost, newspaperId) values
   (key_ad.nextval, 9, CURRENT_DATE, 200, 2);

/* Viewing */
insert into viewing (id, client, associate, propertyId, viewDate, comments) values
   (key_viewing.nextval, 6, 6, 6, TO_DATE('11.15.2011', 'MM.DD.YYYY'), 'This is a really nice place!');

/* Re-enable the FKs */
alter table Branch enable constraint branch_fk1;
