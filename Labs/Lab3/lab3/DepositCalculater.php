<!DOCTYPE html>
<!--
Click nbfs://nbhost/SystemFileSystem/Templates/Licenses/license-default.txt to change this license
Click nbfs://nbhost/SystemFileSystem/Templates/Scripting/EmptyPHPWebPage.php to edit this template
-->
<html>
    <head>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
        <meta charset="UTF-8">
        <title>Deposit Calculator</title>
    </head>
    <body>
        <?php
        
        $inforY = $priAmount*$intRate;
        if ($_SERVER['REQUEST_METHOD'] == 'POST'){
            $priAmount = trim($_POST["priAmount"]);
            $intRate = $_POST["intRate"];
            $years = $_POST["years"];
            $name = $_POST["name"];
            $PosCode = $_POST["PosCode"];
            $phoNum = $_POST["phoNum"];
            $email = $_POST["email"];
            $contact = $_POST["contact"];
            $time = $_POST["time"];
            $Fromvali = false;
            $priAmountErr = ValidatePrincipal($priAmount);
            $intRateErr = ValidateRate($intRate);
            $yearsErr = ValidateYears($years);
            $nameErr = ValidateName($name);
            $PosCodeErr = ValidatePostalCode($PosCode);
            $phoNumErr = ValidatePhone($phoNum);
            $emailErr = ValidateEmail($email);
            $timeErr = ValidateTime($contact, $time);
            
            if(isset($_POST['submit'])){
                if($priAmountErr == ''&&
                $intRateErr == ''&&
                $yearsErr == ''&&
                $nameErr == ''&&
                $PosCodeErr == ''&&
                $phoNumErr == ''&&
                $emailErr == ''&&
                $timeErr ==''){
                $Fromvali = true;
                }
            
            }
            
            
            if(isset($_POST['clear'])) {
            
                $priAmount = "";
                $intRate = "";
                $years = "";
                $name = "";
                $PosCode = "";
                $phoNum = "";
                $email = "";
                $contact = "";
                $time = "";
                $inforY = "";
                $priAmountErr = "";
                $intRateErr = "";
                $yearsErr = "";
                $nameErr = "";
                $PosCodeErr = "";
                $phoNumErr = "";
                $emailErr = "";
                $timeErr = "";
                $Fromvali = false;
             }
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
        function ValidateName($name) {
            if((!isset($name))||(strlen(trim($name))==0)){
                
                return 'Name is required';
                
            }else{
                return '';
            }
        
        }
        function ValidatePostalCode($PosCode) {
            if((!isset($PosCode))||(empty($PosCode))){
                return 'Postal code is required';
            }
            if(!preg_match("/^[ABCEGHJ-NPRSTVXY]\d[ABCEGHJ-NPRSTV-Z][ -]?\d[ABCEGHJ-NPRSTV-Z]\d$/i",$PosCode)){
                return 'Incorrect Postal Code';
            }else{
                return '';
            }
        } 
        function ValidatePhone($phoNum) {
            if((!isset($phoNum))||(empty($phoNum))){
                return 'Phone number is required';
            }
            if(!preg_match("/^[2-9]{1}[0-9]{2}-[2-9]{1}[0-9]{2}-[0-9]{4}/i",$phoNum)){
                return 'Incorrect phone number';
            }else{
                return '';
            }
        }
        function ValidateEmail($email) {
            if((!isset($email))||(empty($email))){
                return 'email is required';
            }
            if(!preg_match("/^[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,4}$/i",$email)){
                return 'Incorrect email';
            }else{
                return '';
            }
        }
        function ValidateTime($contact, $time) {
            if($contact == conPhone && $time==null){
                return 'When preferred contact method is phone, you have to select one or more contact times';
            
            }else{
                return '';
            }
        }
        ?>
        
        <?php if ($Fromvali == false) : ?>
        <div class="container" style="margin-bottom: 20px;">
            <div class="col-xs-6">
                <form class="form-horizontal" id="deCal" method = "post" action="DepositCalculater.php">
                    <h1 class="d-flex justify-content-center mb-5">Deposit Calculator</h1>

                    
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

                    
                    <hr class="form-group row mx-sm-1 mb-3" style="width:100%" , size="4" , color=black>

                    
                    <div class="form-group row mx-sm-3 mb-3 d-flex align-items-center">
                        <label for="name" class="col-sm-3 col-form-label">Name:</label>
                        <div class="col-sm-4">
                            <input type="text" name="name" class="form-control"value="<?php echo $name;?>">
                        </div>
                        <div class="col-sm-5">
                            <span class="error" style="color:red"><?php echo $nameErr;?></span>
                        </div>
                    </div>

                    
                    
                    <div class="form-group row mx-sm-3 mb-2 d-flex align-items-center">
                        <label for="PosCode" class="col-sm-3 col-form-label">Postal Code:</label>
                        <div class="col-sm-4">
                            <input type="text" name="PosCode" class="form-control"value="<?php echo $PosCode;?>">
                        </div>
                        <div class="col-sm-5">
                            <span class="error" style="color:red"><?php echo $PosCodeErr;?></span>
                        </div>
                    </div>

                    <div class="form-inline row mx-sm-3 mb-2 d-flex align-items-center">
                        <label for="phoNum" class="col-sm-3 col-form-label">Phone Number:<br>(nnn-nnn-nnnn)</label>
                        <div class="col-sm-4">
                            <input type="text" name="phoNum" class="form-control"value="<?php echo $phoNum;?>">
                        </div>
                        <div class="col-sm-5">
                            <span class="error" style="color:red"><?php echo $phoNumErr;?></span>
                        </div>
                    </div>

                    <div class="form-group row mx-sm-3 mb-3 d-flex align-items-center">
                        <label for="email" class="col-sm-3 col-form-label">Email Address:</label>
                        <div class="col-sm-4">
                            <input type="text" name="email" class="form-control"value="<?php echo $email;?>">
                        </div>
                        <div class="col-sm-5">
                            <span class="error" style="color:red"><?php echo $emailErr;?></span>
                        </div>
                    </div>

                    <hr class="form-group row mx-sm-1 mb-3" style="width:100%" , size="4" , color=black>

                    <div class="form-group row mx-sm-3 mb-3 d-flex align-items-center">
                        <label for="contact" class="col-sm-3 col-form-label">Preferred contact Method:</label>
                        <div class="col-sm-5">
                            <input type="radio" id="conPhone" name="contact" value="conPhone" <?php if(isset($_POST['contact']) && $_POST['contact'] =='conPhone' ){echo "checked";}?> checked>
                            <label for="conPhone">Phone</label>
                            <input type="radio" id="conEmail" name="contact" value="conEmail" <?php if(isset($_POST['contact']) && $_POST['contact'] =='conEmail' ){echo "checked";}?>>
                            <label for="conEmail">Email</label>
                        </div>
                    </div>

                    
                    <div class="form-group row mx-sm-3 mb-3 d-flex align-items-center">
                        <label for="time" class="col-sm-3 col-form-label">If phone is selected, when can we contact you? <br>(check all applicable)</label>
                        <div class="col-sm-4 ">
                            <div class="mx-sm-0">
                                <input type="checkbox" id="morning" name="time[]" value="morning"<?php echo (in_array('morning',$time))?'checked':''?>>
                                <label for="morning">Morning</label>
                            </div>
                            <div class="mx-sm-0">
                                <input type="checkbox" id="afternoon" name="time[]" value="afternoon"<?php echo (in_array('afternoon',$time))?'checked':''?>>
                                <label for="afternoon">Afternoon</label>
                            </div>
                            <div class="mx-sm-0">
                                <input type="checkbox" id="evening" name="time[]" value="evening"<?php echo (in_array('evening',$time))?'checked':''?>>
                                <label for="evening">Evening</label>
                            </div>
                        </div>
                        <div class="col-sm-5">
                            <span class="error" style="color:red"><?php echo $timeErr;?></span>
                        </div>
                    </div>

                    <div class="mx-sm-4">
                        <button type="submit" value="Submit" name="submit" class="btn btn-success ">Calculate</button>
                        <button type="submit" name="clear" value="clear" class="btn btn-success ">Clear</button>
                    </div>
                    </form>
                
            </div>
        </div>
        <?php endif ?>
        
        <?php if ($Fromvali == true) : ?>
        <?php
            if(count($_POST["time"])>1){
                $secTime = "or <b> $time[1]</b>";
            }
        echo"<div class='mx-auto' style='margin-top: 20px;width: fit-content;'>";
        echo"<h2>Thank You $name, for using our deposit calculator!</h2>";
        if ($_POST["contact"] == "conPhone"){
                $pre = $phoNum;
                echo"<p class='text-center'>Our customer service department will call you tomorrow <b>$time[0]</b> $secTime at <b>$pre</b>.</p>";
            }else{
                $pre = $email;
                echo"<p class='text-center'>An email about the details of our GIC has been sent to <b>$pre</b>.</p>";
            }
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

                    $y = 1;
                    $amountYrSt= $priAmount;
                    $in=$inforY;
                    while($y <= $years)
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
        
    </body>
</html>
