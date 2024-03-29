<?php

require_once('include/include.php');
check();

head('Project Queries and Reports');

startPost('Project Queries and Reports');
?>
<p>Pick from the following queries:</p>
<ol>
   <li><a href="cityBranches.php">List the details of branches in a given city.</a></li>
   <li><a href="stateBranches.php">Find the total number of branches in a given state.</a></li>
   <li><a href="branchEmployees.php">List name, position, and salary of all employees at a given branch, ordered by name.</a></li>
   <li><a href="employeeSalary.php">Find the total number of employees and the sum of their salaries.</a></li>
   <li><a href="baltimorePositions.php">List the number of employees in each position at branches in Baltimore, MD.</a></li>
   <li><a href="branchManagers.php">List the name of branch managers, ordered by branch address.</a></li>
   <li><a href="supervisorAssociates.php">List the names of associates supervised by a given supervisor.</a></li>
   <li><a href="cityProperties.php">List the details of properties in a given city, along with their owners's details, ordered by rent.</a></li>
   <li><a href="branchProperties.php">List the details of properties for rent assigned to each associate at a given branch.</a></li>
   <li><a href="businessProperties.php">List the details of properties provided by business owners at a given branch.</a></li>
   <li><a href="propertyTotals.php">Find the total number of properties of each type at all branches.</a></li>
   <li><a href="multiplePropertyOwners.php">List the details of private property owners that provide more than one property for rent.</a></li>
   <li><a href="baltApartments.php">List the details of apartments with at least two bedrooms in Baltimore, MD with a monthly rent of at most $1200.</a></li>
   <li><a href="clients.php">List the details of clients registered at a branch, together with their preferences, which have not signed a lease yet.</a></li>
   <li><a href="propertyOwner.php">List the details of the owner of a given property.</a></li>
   <li><a href="propertyComments.php">List the comments made by clients that viewed a given property.</a></li>
   <li><a href="avgAd.php">Find those properties that have been advertised more than the average number of times.</a></li>
   <li><a href="expiringLease.php">List the details of leases due to expire next month at a given branch.</a></li>
   <li><a href="stateCount.php">For each state, list the total number of leases with rental duration less than 12 months.</a></li>
   <li><a href="income.php">Find the total current monthly rental income, total monthly management fees, total salaries, as well as the maximum possible monthly rental income and management fee.</a></li>
   <li><a href="notRented.php">List the details of properties that have not been rented out for the last three months.</a></li>
   <li><a href="clientProperties.php">List the details of clients whose preferences match a given property.</a></li>
</ol>
<?php
endPost();

foot();

?>
