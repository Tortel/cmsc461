<?php

require_once('include/include.php');

head('Manage Data');

startPost('Manage Data');
?>
<p>Pick from the following options:</p>

<br>
<h4>View Existing</h4>
<ul>
   <li><a href="viewBranch.php">View Branch Details</a></li>
   <li><a href="viewEmployee.php">View Employee Details</a></li>
   <li><a href="viewClient.php">View Client Details</a></li>
   <li><a href="viewOwner.php">View Owner Details</a></li>
   <li><a href="viewProperty.php">View Property Details</a></li>
   <li><a href="viewLease.php">View Lease Details</a></li>
   <li><a href="viewViewing.php">View Viewing Details</a></li>
   <li><a href="viewNewspaper.php">View Newspaper Details</a></li>
   <li><a href="viewAd.php">View Advertisement Details</a></li>
</ul>

<br>
<h4>Create New</h4>
<ul>
   <li><a href="createBranch.php">Create a new branch</a></li>
   <li><a href="createEmployee.php">Create Employee</a></li>
   <li><a href="createClient.php">Create Client</a></li>
   <li><a href="createOwner.php">Create Owner</a></li>
   <li><a href="createProperty.php">Create Property</a></li>
   <li><a href="createLease.php">Create Lease</a></li>
   <li><a href="createViewing.php">Create Viewing</a></li>
   <li><a href="createNewspaper.php">Create Newspaper</a></li>
   <li><a href="createAd.php">Create Advertisement</a></li>
</ul>

<br>
<h4>Edit Existing</h4>
<ul>
   <li><a href="editBranch.php">Edit Branch</a></li>
   <li><a href="editEmployee.php">Edit Employee</a></li>
   <li><a href="editClient.php">Edit Client</a></li>
   <li><a href="editOwner.php">Edit Owner</a></li>
   <li><a href="editProperty.php">Edit Property</a></li>
   <li><a href="editLease.php">Edit Lease</a></li>
   <li><a href="editViewing.php">Edit Viewing</a></li>
   <li><a href="editAd.php">Edit Advertisement</a></li>
</ul>

<br>
<h4>Delete Existing</h4>
<ul>
   <li><a href="deleteBranch.php">Delete Branch</a></li>
   <li><a href="deleteEmployee.php">Delete Employee</a></li>
   <li><a href="deleteClient.php">Delete Client</a></li>
   <li><a href="deleteOwner.php">Delete Owner</a></li>
   <li><a href="deleteProperty.php">Delete Property</a></li>
   <li><a href="deleteLease.php">Delete Lease</a></li>
   <li><a href="deleteViewing.php">Delete Viewing</a></li>
   <li><a href="deleteNewspaper.php">Delete Newspaper</a></li>
   <li><a href="deleteAd.php">Delete Advertisement</a></li>
<ul>

<?php

endPost();

foot();

?>
