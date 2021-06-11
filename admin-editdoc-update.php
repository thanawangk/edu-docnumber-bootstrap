<?php 
    if(isset($_POST['submit']))
    {
        session_start();
        require("dbConn.php");
        $docid = $_GET["docid"];
        $selectdoc = "select * from document where DocumentID = '".$docid."'";
        $reql = $db->query($selectdoc);
        $rowdoc = $reql->fetch_assoc();
        $sead= $rowdoc["Sent_Name"];
        $to = $rowdoc["Receive_Name"];
        $story = $rowdoc["Text"];

        if($_POST['send'] != '')
        {
            $sead = $_POST['send'];
            print_r("send".$sead);
        }

        if($_POST['to'] != '')
        {
            $to = $_POST['to'];
        }

        if($_POST['story'] != '')
        {
            $story = $_POST['story'];
        }


        
        $namepdf ="";
        $typefile = $_FILES["fileUpload"]["type"];

        if($_FILES['fileUpload']['size'] != 0 )
        {
            $namepdf = $_FILES["fileUpload"]["name"];
            $updatedoc = "update document  set  Sent_Name = '$sead',Receive_Name ='$to',Text='$story',Filee='$docid.pdf' where DocumentID = '$docid'";
        }
        else
        {
            $updatedoc = "update document  set  Sent_Name = '$sead',Receive_Name ='$to',Text='$story' where DocumentID = '$docid'";
        }  

        if ($reql = $db->query($updatedoc)) {
            echo "Record updated successfully<br>";
        }

        if($_FILES['fileUpload']['size'] != 0 and $typefile == 'application/pdf')
        {
        $destination = 'uploads/'.$docid.'.pdf';
        $extension = pathinfo($namepdf, PATHINFO_EXTENSION);
        $size = $_FILES['fileUpload']['size'];
        $file = $_FILES['fileUpload']['tmp_name'];
        if (!in_array($extension, ['pdf', 'docx'])) {
            echo "You file extension must be .zip, .pdf or .docx";
        } elseif ($_FILES['fileUpload']['size'] > 1000000) { // file shouldn't be larger than 1Megabyte
            echo "File too large!";
        } else {
      
            if (move_uploaded_file($file, $destination)) {
                    echo "File uploaded successfully";
                }
            else {
                echo "Failed to upload file.";
            }
         }
    }
        
    header("location: admin-home.php");
}
?>
