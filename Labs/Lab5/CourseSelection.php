<?php include("./common/header.php"); ?>


<?php
session_start(); 				
if ($_SESSION["LogInVali"]==false)
{
    header("Location: Login.php");
    exit( );
}




?>

<?php include('./common/footer.php'); ?>