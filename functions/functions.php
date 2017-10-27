<?php

//saves the userinput in case s/he forgets to add username s/he wont have to fill
//out the task again

function getFormData($inputname) {
   if (isset($_SESSION["formData"]) && isset($_SESSION["formData"][$inputname])){
        return $_SESSION["formData"][$inputname];
   } 
   else {
       return "";
   }
}