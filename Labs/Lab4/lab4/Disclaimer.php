<?php
    session_start();
    $termsErr="";
    $termCheck="";
    if (isset($_POST["Start"]))
        {
        if(isset($_POST['terms']) && 
            $_POST['terms'] == 'agree') 
        {
            $_SESSION["terms"] = true;
            header("location: CustomerInfo.php");
        }
        else
        {
            $termsErr = "You must agree the terms and conditions";
            $_SESSION["terms"] = null;
        }
    }else {
        if(isset($_SESSION["terms"]))
        {
          $termCheck = "checked";
        }
    }
    include("./common/header.php");
?>
        
        <div class="text-center">
            <h1> Terms and Conditions</h1>
            <div class="px-5 pt-2">
            <p class="border border-secondary px-3 pt-2 pb-2">I agree to abide by the Bank's Terms and Conditions and rules in force and the changes thereto in Terms and Conditions from time to time relating to my account as communicated and make available on the Bank's website</p>
            <p class="border border-secondary px-3 pt-2 pb-2">I agree that the bank before opening any deposit account, will carry out a due diligence as required under know Your Customer guidelines of the bank. I would be required to submit necessary documents or proofs, such as identity, addressm photograph and any such information, I agree to submit the above documents again at periodic intervals, as may be required by the bank.</p>
            <p class="border border-secondary px-3 pt-2 pb-2">I agree that the bank can at its sole discretion, amend any of the services/facilities given in my account either wholly ot partially at any time by giving me at least 30 days notice and/or provide an option to me to switch to other sevices/facilities.</p>
            </div>
            <form class="form-horizontal" id="termsF" method = "post" action="Disclaimer.php">
                
                <div class="mx-sm-0">
                    <span class="error" style="color:red"><?php echo $termsErr;?></span>
                </div>
                <div class="mx-sm-0">
                    
                    <input type="checkbox" name="terms" value="agree" <?php echo $termCheck; ?>/>
                    I have read and agree with the terms and conditions
                </div>
                
                    <input type="submit" name="Start" value="Start" class="btn btn-success" />
                </div>
            </form> 
        </div>
<?php include('./common/footer.php'); ?>
