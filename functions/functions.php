<?php

function getFormData($inputname) {
   if (isset($_SESSION["formData"]) && isset($_SESSION["formData"][$inputname])){
        return $_SESSION["formData"][$inputname];
   } 
   else {
       return "";
   }
}