<?php

require_once('include/include.php');

$db = dbConnect();

head('View Viewing');

$id = $_GET['id'];

if((!$id && $id != 0) || !is_numeric($id)){
   $viewQuery = dbExec($db, 'select id, propertyId, TO_CHAR(viewDate, \'DD.MM.YYYY\') from viewing');
   
   startPost('Select Viewing');
   ?>
   <form action="<?php echo htmlentities($_SERVER['PHP_SELF']); ?>" method="get">
      <select name="id" id="id">
      <?php
         while( ($row = dbFetchRow($viewQuery)) ){
            echo '<option value="'.$row[0].'">'.$row[0].' - For Property '.$row[1].' on '.$row[2].'</option>';
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
   
   startPost("Viewing $id");
   
   $query = dbExec($db, "select client, associate, propertyid, TO_CHAR(viewDate, 'DD.MM.YYYY'), comments from viewing where id = $id");
   
   $row = dbFetchRow($query);
   ?>
   <table>
      <tr>
         <td>Client:</td>
         <td><a href="viewClient.php?id=<?php echo $row[0] ?>">Client <?php echo $row[0] ?></a></td>
      </tr>
      <tr>
         <td>Associate:</td>
         <td><a href="viewEmployee.php?id=<?php echo $row[1] ?>">Employee <?php echo $row[1] ?></a></td>
      </tr>
      <tr>
         <td>Property:</td>
         <td><a href="viewProperty.php?id=<?php echo $row[2] ?>">Property <?php echo $row[2] ?></a></td>
      </tr>
      <tr>
         <td>Comments:</td>
         <td><?php echo $row[5]; ?></td>
      </tr>
   </table>
   <?php
   endPost();
   
  foot(); 
}
?>
