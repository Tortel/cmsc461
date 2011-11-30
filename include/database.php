<?php


function dbConnect(){
   
   $conn = oci_connect('461', 'cmsc461', '//localhost/XE');
   if (!$conn) {
      $m = oci_error();
      die($m['message']);
   }
   else {
      return $conn;
   }
}


?>
