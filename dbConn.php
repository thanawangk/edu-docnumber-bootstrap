<?php

$db = mysqli_connect("localhost","root","","myqumber");

if(!$db)
{
    die("Connection failed: " . mysqli_connect_error());
}
$db->set_charset("utf8");
?>