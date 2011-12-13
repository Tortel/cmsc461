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
</ul>

<br>
<h4>Create New</h4>
<ul>
   <li><a href="createBranch.php">Create a new branch</a></li>
   <li><a href="createEmployee.php">Create Employee</a></li>
   <li><a href="createClient.php">Create Client</a></li>
   <li><a href="createOwner.php">Create Owner</a></li>
</ul>

<br>
<h4>Edit Existing</h4>
<ul>
   <li><a href="editBranch.php">Edit Existing Branch</a></li>
   <li><a href="editEmployee.php">Edit Existing Employee</a></li>
   <li><a href="editClient.php">Edit Existing Client</a></li>
   <li><a href="editOwner.php">Edit Existing Owner</a></li>
</ul>

<br>
<h4>Delete Existing</h4>
<ul>
   <li><a href="deleteBranch.php">Delete Branch</a></li>
   <li><a href="deleteEmployee.php">Delete Employee</a></li>
   <li><a href="deleteClient.php">Delete Client</a></li>
   <li><a href="deleteOwner.php">Delete Owner</a></li>
<ul>


<?php

endPost();

foot();

?>
