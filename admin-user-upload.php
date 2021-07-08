<?php
include "dbConn.php"; 
require 'PhpSpreadsheet/vendor/autoload.php';

use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xls;

$spreadsheet = new Spreadsheet();
$sheet = $spreadsheet->getActiveSheet();
$namepdf ="";
$typefile = $_FILES["fileUpload"]["type"];

$selecttypeuse = "select Email from user";
$reqltype = $db->query($selecttypeuse);

$listemail = array('');
while ($oldemail = $reqltype->fetch_assoc()) {
    array_push($listemail, $oldemail['Email']);
}

if(isset($_POST['submit']))
{
    if($_FILES['fileUpload']['size'] != 0 && $typefile == 'application/vnd.ms-excel')
    {
        $newword = array('');
        $inputFileName = $_FILES["fileUpload"]["name"];
        $test = $_FILES["fileUpload"]["tmp_name"];

        $spreadsheet = IOFactory::load($test);
        $sheetData = $spreadsheet->getActiveSheet()->toArray(null, true, true, true);

        $i = 0;
        $j = 1;
        $data = [];

        foreach($sheetData as $s => $k){
            foreach($k as $g){
                $i++;
                $data[$j][] = $g;
            }
            $j++;
        }
        $i = 1;
        foreach($data as $q){
            
            if($i > 1){
                $name = trim($q[0]);
                $lastname = trim($q[1]);
                $status = trim($q[2]);
                $email = trim($q[3]);
                $phone = trim($q[4]);
                
                if(!in_array($email,$listemail))
                {
                    $insert = mysqli_query($db,"INSERT INTO `user`(`Status`,`Name`,`Surname`,`Email`,`Phone`) VALUES ('$name','$lastname','$status','$email','$phone')");
                }         
            }
            $i++;
        }
        echo "<script>";
        echo "window.location.href = 'admin-users.php';";
        echo "alert('เพิ่มสมาชิกเสร็จสิ้น');";
        echo "</script>"; 
    }

    else
    {
        echo "<script>";
        echo "alert('กรุณาเลือกไฟล์ที่ต้องการเพิ่ม');";
        echo "window.location.href = 'admin-users.php';";
        echo "</script>"; 
    }
}

if(isset($_POST['submitmit']))
{
    header("Content-Type: application/vnd.ms-excel");
    header("Content-Disposition: attachment; filename=example.xls");
    header("Pragma: no-cache");
    header("Expires: 0");

    $spreadsheet = new Spreadsheet();
    $sheet = $spreadsheet->getActiveSheet();
    $sheet->setCellValue('A1', 'Status');
    $sheet->setCellValue('B1', 'Name');
    $sheet->setCellValue('C1', 'Lastname');
    $sheet->setCellValue('D1', 'Email');
    $sheet->setCellValue('E1', 'Phone');

    $writer = new Xls($spreadsheet);
    $writer->save('php://output');
}

?>
 