<?php


function db_connect(){
   $username = "461";
   $password = "cmsc461";   
   
   $conn = oci_connect($username, $password, "//localhost/orcl");
   if (!$conn) {
      $m = oci_error();
      die($m['message']);
   }
   else {
      return $conn;
   }
}


?>
