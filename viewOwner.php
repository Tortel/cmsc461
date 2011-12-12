<?php

require_once('include/include.php');

$db = dbConnect();

head('View Owner Details');

$id = $_GET['id'];

/*
   id number(10) primary key,
   name varchar2(100),
   street varchar2(250),
   city varchar2(250),
   state varchar2(2),
   zip varchar2(5),
   phone varchar2(10),
   fax varchar2(10),
   isBusiness char(1),
*/
if( (!$id || !($id == 0)) || !is_numeric($id) ){
   $ownersQuery = dbExec($db, 'select id, name, city, state from Owner');
   
   startPost('Select Owner');
   
   ?>
   
   <form action="<?php echo htmlentities($_SERVER['PHP_SELF']); ?>" method="get">
      <select name="id" id="id">
      <?php
         while( ($row = dbFetchRow($ownersQuery)) ){
            echo '<option value="'.$row[0].'">'.$row[1].' - '.$row[2].', '.$row[3].'</option>';
         }
      ?>
      </select>
      <input type="submit" value="Submit">
   </form>
   
   <?php
   
   endPost();
   
   foot();
   
   exit();
   
} else {
   
   $ownerQuery = dbExec($db, "select name, street, city, state, zip, phone, fax, isBusiness from Owner where id = $id");
   
   $row = dbFetchRow($ownerQuery);
   
   startPost('Owner Details');
   
   
   ?>
   
   
   
   
   
   <?php
   
   endPost();
   
   foot();
   
   
}

?>
