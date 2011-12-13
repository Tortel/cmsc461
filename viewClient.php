<?php

require_once('include/include.php');

head('Client Details');

$id = $_GET['id'];

$db = dbConnect();

if( (!$id && $id != 0) || !is_numeric($id)){
   
   $client = dbExec($db, 'select id, firstname, lastname from Client');
   
   startPost('Select Client');
   ?>
   <form action="<?php echo htmlentities($_SERVER['PHP_SELF']); ?>" method="get">
      <select name="id" id="id">
      <?php
         while( ($row = dbFetchRow($client)) ){
            echo '<option value="'.$row[0].'">'.$row[0].' - '.$row[1].' '.$row[2].'</option>';
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
} else {
   startPost('Client Details');
   
   $query = dbExec($db, "Select firstName, lastName, street, city, state, zip, phone, workphone, propertyType, maxRent, registerDate, associate, branch from Client where id = $id");
   
   $row = dbFetchRow($query);
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
   <?php
   
   endPost();
   
   foot();
   
}
?>
