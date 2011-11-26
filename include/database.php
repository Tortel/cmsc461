<?php

class Database {
   private $username = "461";
   private $password = "cmsc461";
   
   function connect(){
      return oci_connect($username, $password, 'localhost');
   }
   
   
}

?>
