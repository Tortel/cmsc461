<?php

/**
 * Opens a Oracle database connection.
 * Dies on error.
 */
function dbConnect(){
   $conn = oci_connect('cmsc461', 'cmsc461', '//localhost/XE');
   if (!$conn) {
      $m = oci_error();
      die($m['message']);
   }
   else {
      return $conn;
   }
}

/**
 * Parses a query for Oracle.
 * Dies on error
 */
function dbParse($db, $query){
   $toRet = oci_parse($db, $query); 
   if (!$toRet){
      $e = oci_error($db);
      echo '<pre>';
      echo $query;
      trigger_error(htmlentities($e['message'], ENT_QUOTES), E_USER_ERROR);
   }
   
   return $toRet;
}

/**
 * Escapes strings for use in a Oracle query.
 * Dies on error
 */
function dbEscape($string){
   $tmp = str_replace("'", "''", $string);
   return $tmp;
}

/**
 * Executes a parsed Oracle query.
 * Dies on error
 */
function dbExecute($query){
   $r = oci_execute($query);
   if(!$r){
      $e = oci_error($query);
      echo '<pre>';
      echo $e['sqltext'].' -- '.$e['offset'];
      trigger_error(htmlentities($e['message'], ENT_QUOTES), E_USER_ERROR);
   }
}

/**
 * Both parses and executes an Oracle query.
 * Dies on error
 */
function dbExec($db, $query){
   $toRet = dbParse($db, $query);
   
   dbExecute($toRet);
   
   return $toRet;
}

/**
 * Fetches the next row from a executed Oracle query.
 * The returned array is both associative (Can name fields) and numeric
 * Associative doesnt seem to work...
 */
function dbFetchRow($query){
   return oci_fetch_array($query, OCI_BOTH+OCI_RETURN_NULLS);
}

/**
 * Makes an insert date  statement.
 * Date needs to be in mm.dd.yyyy
 * (Ex 12.10.1990)
 */
function dbDate($date){
   return "TO_DATE('$date', 'MM.DD.YYYY')";
}

/**
 * Fetches all the rows from a query, returns a 2-dimensional array.
 */
function dbFetchAll($query){
   oci_fetch_all($query, $array, 0, -1, OCI_FETCHSTATEMENT_BY_ROW+OCI_NUM);
   return $array;
}


?>
