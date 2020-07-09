<?php
   defined('BASEPATH') OR exit('No direct script access allowed');
   require('fpdf/fpdf.php');

   class Mypdf extends Fpdf
   {
       function _construct(){
           parent::__construct();
           $CI=& get_instance();
       }
   }
   
?>