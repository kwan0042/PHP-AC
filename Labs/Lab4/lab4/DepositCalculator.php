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
    
    $priAmountErr = '';
    $intRateErr = '';
    $yearsErr = '';
    $Fromvali = false;
    
    $priAmount = $_POST["priAmount"];
    $intRate = $_POST["intRate"];
    $years = $_POST["years"];
    

    if(isset($_POST['Calculate'])){
        $priAmountErr = ValidatePrincipal($priAmount);
        $intRateErr = ValidateRate($intRate);
        $yearsErr = ValidateYears($years);
        

        if($priAmountErr == ''&&
        $intRateErr == ''&&
        $yearsErr == '')
        {
            $_SESSION["priAmount"] = $priAmount;
            $_SESSION["intRate"] = $intRate;
            $_SESSION["years"] = $years;
            $Fromvali = true;
        }
    }else {
        if(isset($_SESSION["priAmount"]))
        {
            $priAmount = $_SESSION["priAmount"];
            $intRate = $_SESSION["intRate"];
            $years = $_SESSION["years"];
        }
    }
    
    
    if(isset($_POST['Complete'])){
        header("Location: Complete.php");
        exit();
    }
    
    if(isset($_POST['Previous'])){
        if(isset($_POST["priAmount"]))
        {
            $priAmount = $_SESSION["priAmount"];
            $intRate = $_SESSION["intRate"];
            $years = $_SESSION["years"];
        }
        header("Location: CustomerInfo.php");
        exit();
    }

    function ValidatePrincipal($priAmount) {
        if((empty($priAmount))){
            return 'Principal amount can not be Blank';
        }
        if(is_numeric($priAmount)==null){
            return 'Principal amount must be a numeric';
        }
        if($priAmount <0){
            return 'Principal amount must greater than 0';

        }else{
            return '';
        }
    }             
    function ValidateRate($intRate) {
        if((!isset($intRate))||(strlen(trim($intRate))==0)){
            return 'The principal amount can not be Blank';
        }
        if(is_numeric($intRate)==null){
            return 'Interest rate must be a numeric';
        }
        if($intRate <0){
            return 'Interest rate must be non-negative';

        }else{
            return '';
        }
    }      
    function ValidateYears($years) {
        if($years==0){

            return 'Number of years to deposit must be a numeric between 1 and 20';

        }else{
            return '';
        }
    }
    
    include("./common/header.php"); 
    ?>
        
        
        <div class="container mx-auto" style="margin-top: 20px;width: fit-content;">
            <div class="col-xs-6">
                <form class="form-horizontal" id="deCal" method = "post" action="DepositCalculator.php">
                    <h5 class="d-flex justify-content-center mt-5 mb-5">Enter principal amount, interest rate and select number of years to deposit</h5>

                    
                    <div class="form-group row  mx-sm-3 mb-3 d-flex align-items-center">
                        <label for="priAmount" class="col-sm-3 col-form-label">Principal Amount:</label>
                        <div class="col-sm-4">
                            <input type="text" name="priAmount" class="form-control" value="<?php echo $priAmount;?>">
                            
                        </div>
                        <div class="col-sm-5">
                            <span class="error" style="color:red"><?php echo $priAmountErr;?></span>
                        </div>
                        
                    </div>
                    

                    <div class="form-group row mx-sm-3 mb-3 d-flex align-items-center">
                        <label for="intRate" class="col-sm-3 col-form-label">Interest Rate (%):</label>
                        <div class="col-sm-4">
                            <input type="text" name="intRate" class="form-control"value="<?php echo $intRate;?>">
                        </div>
                        <div class="col-sm-5">
                            <span class="error" style="color:red"><?php echo $intRateErr;?></span>
                        </div>
                    </div>
                    

                    <div class="form-group row mx-sm-3 mb-3 d-flex align-items-center">
                        <label for="years" class="col-sm-3 col-form-label">Years to Deposit:</label>
                        <div class="col-sm-4">
                            <select  name="years" class="form-control"value="<?php echo $years;?>">
                                <option value="0"<?php echo ($years=='0'?'selected':'')?>>Select...</option>
                                <option value="1"<?php echo ($years=='1'?'selected':'')?>>1</option>
                                <option value="2"<?php echo ($years=='2'?'selected':'')?>>2</option>
                                <option value="3"<?php echo ($years=='3'?'selected':'')?>>3</option>
                                <option value="4"<?php echo ($years=='4'?'selected':'')?>>4</option>
                                <option value="5"<?php echo ($years=='5'?'selected':'')?>>5</option>
                                <option value="6"<?php echo ($years=='6'?'selected':'')?>>6</option>
                                <option value="7"<?php echo ($years=='7'?'selected':'')?>>7</option>
                                <option value="8"<?php echo ($years=='8'?'selected':'')?>>8</option>
                                <option value="9"<?php echo ($years=='9'?'selected':'')?>>9</option>
                                <option value="10"<?php echo ($years=='10'?'selected':'')?>>10</option>
                                <option value="11"<?php echo ($years=='11'?'selected':'')?>>11</option>
                                <option value="12"<?php echo ($years=='12'?'selected':'')?>>12</option>
                                <option value="14"<?php echo ($years=='13'?'selected':'')?>>13</option>
                                <option value="14"<?php echo ($years=='14'?'selected':'')?>>14</option>
                                <option value="15"<?php echo ($years=='15'?'selected':'')?>>15</option>
                                <option value="16"<?php echo ($years=='16'?'selected':'')?>>16</option>
                                <option value="17"<?php echo ($years=='17'?'selected':'')?>>17</option>
                                <option value="18"<?php echo ($years=='18'?'selected':'')?>>18</option>
                                <option value="19"<?php echo ($years=='19'?'selected':'')?>>19</option>
                                <option value="20"<?php echo ($years=='20'?'selected':'')?>>20</option>
                            </select>
                        </div>
                        <div class="col-sm-5">
                            <span class="error"  style="color:red"><?php echo $yearsErr;?></span>
                        </div>
                    </div>
                    <br>
                    <div class="d-flex justify-content-center mt-3">
                        <button type="submit" value="Previous" name="Previous" class="btn btn-success mx-2">< Previous</button>
                        <button type="submit" value="Calculate" name="Calculate" class="btn btn-success mx-4">Calculate</button>
                        <button type="submit" value="Complete" name="Complete" class="btn btn-success mx-2">Complete ></button>
                    </div>
                </form>
            </div>
        </div>

<?php if ($Fromvali == true) : ?>
    <?php
    echo"
        </div>
        <br>
        <div class='row d-flex justify-content-center text-center'>
        <table class='table table-striped table-dark' style='width: 60%';>
        <p>The following is the result of the calculation:</p>
        <thead class='thead-dark'>
                <tr>
                   <td scope='col'>Year </td>
                   <td scope='col'>Principal at Year Start</td>
                   <td scope='col'>Interest for the Year</td>
                </tr>
            </thead>";

            echo"<tbody>";

                $y = 0;
                $amountYrSt= $priAmount;
                $in=$inforY;
                while($y < $years)
                    {
                        $y=$y+1;
                        $amountYrSt=$amountYrSt+$in;
                        $in=$amountYrSt*($intRate/100);
                        echo"<tr>";
                        echo"<td>";
                        echo $y;
                        echo"</td>";
                        echo"<td>$";
                        printf("%.2f",$amountYrSt);
                        echo"</td>";
                        echo"<td>$";
                        printf("%.2f",$in);
                        echo"</td>";
                        echo"</tr>";
                    }

        echo"</tbody>";
        echo"</table>
        </div>";
    ?>
<?php endif ?>
    

        
<?php include('./common/footer.php'); ?>
