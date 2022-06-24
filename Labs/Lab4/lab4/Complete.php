<?php 
    session_start(); 				
    if (!isset($_SESSION["terms"]))
    {
            header("Location: Disclaimer.php");
            exit( );
    }
    if(!isset($_SESSION["name"]))
	{
            header("Location: CustomerInfo.php");
            exit();
	}
    include("./common/header.php"); 
    
    
    $checked_count=count($_SESSION["time"]);
    if($checked_count>1){
        $secTime = ' or <b>'.$_SESSION["time"][1].'</b>';
    }
    
    
    ?>      
    <div class="mx-auto" style="margin-top: 20px;width: fit-content;">
    <h2>Thank You <?php echo $_SESSION["name"]?>, for using our deposit calculatoion tool!</h2>
    </div>
    <?php 
    if ($_SESSION["contact"] == "conPhone"){
        $pre = $_SESSION["phoNum"];
        echo '<p class="text-center">Our customer service department will call you tomorrow <b>'.$_SESSION["time"][0].'</b>'.$secTime .' at <b>'.$pre.'</b></p>';
        }else{
        $pre = $_SESSION["email"];
        echo'<p class="text-center">An email about the details of our GIC has been sent to <b>'.$pre.'</b>.</p>';
        }
    ?>
    
<?php            
session_destroy();
include('./common/footer.php'); 
?>