<?php

/**
 * Returns the name of the type of property
 */
function propertyType($type){
   if($type == 0){
      return 'Apartment';
   } else if($type == 1){
      return 'Townhouse';
   } else {
      return 'Single family house';
   }
}



?>
