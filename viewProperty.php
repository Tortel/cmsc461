<?php

require_once('include/include.php');

head('Property Details');

$id = $_GET['id'];

$db = dbConnect();

if((!$id && $id != 0) || !is_numeric($id)){
   //Branch not selected, show option to select one
   
   $branchesQuery = dbExec($db, 'select id, street, city, state from property');
   
   startPost('Select Property');
   ?>
   <form action="<?php echo htmlentities($_SERVER['PHP_SELF']); ?>" method="get">
      <select name="id" id="id">
      <?php
         while( ($row = dbFetchRow($branchesQuery)) ){
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
} else {
   
   $query = dbExec($db, "Select Property.street, Property.city, property.state, Property.zip, type, bedrooms, bathrooms, sqfoot, rent, name, Owner.id from Property, owner where property.owner = owner.id and property.id = $id");
   
   $row = dbFetchRow($query);
   
   ?>
      <table>
      <tr>
         <td>Address:</td>
         <td><?php echo $row[0].'<br>'.$row[1].', '.$row[2].'<br>'.$row[3]; ?></td>
      </tr>
      <tr>
         <td>Type:</td>
         <td><?php echo propertyType($row[4]); ?></td>
      </tr>
      <tr>
         <td>Bedrooms:</td>
         <td><?php echo $row[5]; ?></td>
      </tr>
      <tr>
         <td>Bathrooms:</td>
         <td><?php echo $row[6]; ?></td>
      </tr>
      <tr>
         <td>Square Feet:</td>
         <td><?php echo $row[7]; ?></td>
      </tr>
      <tr>
         <td>Rent:</td>
         <td>$<?php echo $row[8]; ?></td>
      </tr>
      <tr>
         <td>Owner:</td>
         <td><a href="viewOwner.php?id=<?php echo $row[10]; ?>"><?php echo $row[9]; ?></a></td>
      </tr>
   </table>

   <?php
   
   endPost();
   
   foot();
   
   
}
?>
