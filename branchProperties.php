<?php

require_once('include/include.php');

$db = dbConnect();

head('View Branch Properties');

$branch = $_GET['id'];

if( (!$branch && $branch != 0) || !is_numeric($branch)){
   //Branch not selected, show option to select one
   
   $branchesQuery = dbExec($db, 'select id, city, state from Branch');
   
   startPost('Select Branch');
   ?>
   <form action="<?php echo htmlentities($_SERVER['PHP_SELF']); ?>" method="get">
      <select name="id" id="id">
      <?php
         while( ($row = dbFetchRow($branchesQuery)) ){
            echo '<option value="'.$row[0].'">'.$row[0].' - '.$row[1].', '.$row[2].'</option>';
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
   
   startPost('Branch Associates and Available Properties');
   
   $associates = dbExec($db, "select Associate.id, firstName, lastName from Associate, Employee where associate.id = employee.id and employee.branch = $branch order by lastName desc");
   
   while( ($associateRow = dbFetchRow($associates)) ){
      echo '<b>'.$associateRow[2].', '.$associateRow[1].'</b>';
      
      $propertyQuery = dbExec($db, "Select Property.street, Property.city, property.state, Property.zip, type, bedrooms, bathrooms, sqfoot, rent, name, Owner.id from Property, owner where property.owner = owner.id and rented = 'N' and property.associate = $associaterow[0] order by rent asc");
      
      while( ($row = dbFetchRow($propertyQuery)) ){
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
         <br />
         <?php
      }
      
      echo '<br />';
      
   }
   
   endPost();
   
   foot();
   
}
?>
