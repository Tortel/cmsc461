<?php

require_once('include/include.php');
check();

$db = dbConnect();

head('View Branch Business Properties');

$branch = $_GET['id'];

if(!$branch || !is_numeric($branch)){
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
   
   startPost("Branch $branch Properties owned by Businesses");
   
   $propertyQuery = dbExec($db, "Select Property.street, Property.city, property.state, Property.zip, type, bedrooms, bathrooms, sqfoot, rent, name, Owner.id from Property, owner ,employee where property.associate = Employee.id and property.owner = owner.id and isBusiness = 'Y' and employee.branch = $branch order by rent asc");
   
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
   
   endPost();
   
   foot();
   
}
?>
