<?php
    $filename = $_GET["filename"];
    header('Content-type: application/pdf');
      
    header('Content-Disposition: inline; filename="' . $filename . '"');
      
    header('Content-Transfer-Encoding: binary');
      
    header('Accept-Ranges: bytes');
    @readfile($filename);
    
?>