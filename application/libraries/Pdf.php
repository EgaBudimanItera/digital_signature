
<?php
    defined('BASEPATH') OR exit('No direct script access allowed');
    // use setasign\Fpdi;
    // require_once APPPATH.'third_party/tcpdf/tcpdf.php ';
    // require_once APPPATH.'third_party/setasign/fpdi/fpdi.php ';
    use setasign\Fpdi;
    use setasign\fpdf;
    require_once APPPATH.'third_party/vendor/setasign/tcpdf/tcpdf.php';
    require_once APPPATH.'third_party/vendor/setasign/fpdi/src/Fpdi.php';
   class Pdf extends FPDI
   {
       function _construct(){
           parent::__construct();
          
       }
   }
   
?>
