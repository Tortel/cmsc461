<?php

require_once('include/include.php');

$db = dbConnect();

if($_POST['submit']){
   
   $id = $_POST['id'];
   
   if( is_numeric($id) ){
      
      //Should auto-fail if there is any foreign keys dependent on that employee
      //Manager is removed from manager table automatically
      dbExec($db, "delete from Owner where id = $id");
      
      //Redirect them
      header('Location: viewOwner.php');
   }
   
}

head('Delete Owner');

startPost('Delete Owner');

$branchesQuery = dbExec($db, 'select id, name, city, state from Owner');

?>
<form action="<?php echo htmlentities($_SERVER['PHP_SELF']); ?>" method="post">
   <input type="hidden" name="submit" id="submit" value="1">
   <table border="0">
   <tr>
      <td>Delete Owner:</td>
      <td>
         <select id="id" name="id">
            <?php
               while( ($row = dbFetchRow($branchesQuery)) ){
                  echo '<option value="'.$row[0].'">'.$row[0].' - '.$row[1].', '.$row[2].', '.$row[3].'</option>';
               }
            ?>
         </select>
      </td>
   </tr>
   <tr>
   <td colsan="2" align="center">
      <input type="submit" value="Submit" />
   </td>
   </tr>
   </table>
</form>
<?php

endPost();

foot();

?>
