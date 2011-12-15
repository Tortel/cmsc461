<?php

require_once('include/include.php');

$db = dbConnect();

$id = $_GET['id'];

head('Clients that Match Property');

if((!$id && $id != 0) || !is_numeric($id)){
   
   $propertyQuery = dbExec($db, 'select id, street, city, state from property');
   
   startPost('Select Property');
   ?>
   <form action="<?php echo htmlentities($_SERVER['PHP_SELF']); ?>" method="get">
      <select name="id" id="id">
      <?php
         while( ($row = dbFetchRow($propertyQuery)) ){
            echo '<option value="'.$row[0].'">'.$row[0].' - '.$row[1].', '.$row[2].', '.$row[3].'</option>';
         }
      ?>
      </select>
      
      <br>
      <input type="submit" value="Submit">
   </form>
   <?php
   
   endPost();
   
   foot();
   
   exit();
}

$query = dbExec($db, "Select firstName, lastName, street, city, state, zip, phone, workphone, propertyType, maxRent, registerDate, associate, branch from Client where id in (select client.id from client, property where rent <= client.maxRent and propertyType = property.type and property.id = $id)");

while( ($row = dbFetchRow($query)) ){
   ?>
   <table>
      <tr>
         <td>First Name:</td>
         <td><?php echo $row[0]; ?></td>
      </tr>
      <tr>
         <td>Last Name:</td>
         <td><?php echo $row[2]; ?></td>
      </tr>
      <tr>
         <td>Address:</td>
         <td>
            <?php
               echo $row[3].'<br>';
               echo $row[4].', '.$row[5].'<br>';
               echo $row[6];
            ?>
         </td>
      </tr>
      <tr>
         <td>Home Phone:</td>
         <td><?php echo $row[7]; ?></td>
      </tr>
      <tr>
         <td>Work Phone:</td>
         <td><?php echo $row[8]; ?></td>
      </tr>
      <tr>
         <td>Property Prefrence:</td>
         <td><?php echo propertyType($row[9]); ?></td>
      </tr>
      <tr>
         <td>Maximum Rent:</td>
         <td>$<?php echo $row[10]; ?></td>
      </tr>
      <tr>
         <td>Register Date:</td>
         <td><?php echo $row[10]; ?></td>
      </tr>
      <tr>
         <td>Registering Associate:</td>
         <td><a href="viewEmployee.php?id=<?php echo $row[11]; ?>">Employee <?php echo $row[11]; ?></a></td>
      </tr>
      <tr>
         <td>Branch:</td>
         <td><a href="viewBranch.php?id=<?php echo $row[12]; ?>">Branch <?php echo $row[12]; ?></a></td>
      </tr>
   </table>
   <br />
   <?php
}

endPost();

foot();
?>
