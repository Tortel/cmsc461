<?php

require_once('include/include.php');
check();

$db = dbConnect();

if($_POST['submit']){
   
   $id = $_POST['id'];
   
   if( is_numeric($id) ){
      
      //Should auto-fail if there is any foreign keys dependent on that employee
      //Manager is removed from manager table automatically
      dbExec($db, "delete from Client where id = $id");
      
      //Redirect them
      header('Location: viewClient.php');
   }
   
}

head('Delete Client');

startPost('Delete Client');
   
$clientQuery = dbExec($db, 'select id, lastName, firstName from client');

?>
<form action="<?php echo htmlentities($_SERVER['PHP_SELF']); ?>" method="post">
   <input type="hidden" name="submit" id="submit" value="1">
   <table border="0">
   <tr>
      <td>Delete Client:</td>
      <td>
         <select id="id" name="id">
            <?php
               while( ($row = dbFetchRow($clientQuery)) ){
                  echo '<option value="'.$row[0].'">'.$row[0].' - '.$row[1].', '.$row[2].'</option>';
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
