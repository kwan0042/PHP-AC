<?php 
    session_start(); 				
    if (!isset($_SESSION["terms"]))
    {
            header("Location: Disclaimer.php");
            exit( );
    }
    
        $nameErr = '';
        $PosCodeErr = '';
        $phoNumErr = '';
        $emailErr = '';
        $timeErr ='';
        
    
        $name = $_POST["name"];
        $PosCode = $_POST["PosCode"];
        $phoNum = $_POST["phoNum"];
        $email = $_POST["email"];
        $contact = $_POST["contact"];
        $time = $_POST["time"];

        


        if(isset($_POST['Next'])){
            $nameErr = ValidateName($name);
            $PosCodeErr = ValidatePostalCode($PosCode);
            $phoNumErr = ValidatePhone($phoNum);
            $emailErr = ValidateEmail($email);
            $timeErr = ValidateTime($contact, $time);
            
            if($nameErr == ''&&
            $PosCodeErr == ''&&
            $phoNumErr == ''&&
            $emailErr == ''&&
            $timeErr =='')
            {
                $_SESSION["name"] = $name;
                $_SESSION["PosCode"] = $PosCode;
                $_SESSION["phoNum"] = $phoNum;
                $_SESSION["email"] = $email;
                $_SESSION["contact"] = $contact;
                $_SESSION["time"] = $time;

                header("Location: DepositCalculator.php");
                exit();

            }
        }else {
            if(isset($_SESSION["name"]))
            {
                $name = $_SESSION["name"];
                $PosCode = $_SESSION["PosCode"];
                $phoNum = $_SESSION["phoNum"];
                $email = $_SESSION["email"];
                $contact = $_SESSION["contact"];
                $time = $_SESSION["time"];	
                
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
            if(!preg_match("/^[2-9]{1}[0-9]{2}-[2-9]{1}[0-9]{2}-[0-9]{4}$/i",$phoNum)){
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
    include("./common/header.php"); 
?>
        <div class="container" style="margin-bottom: 20px;">
            <div class="col-xs-6">
                <form class="form-horizontal" id="deCal" method = "post" action="CustomerInfo.php">
                    <h1 class="mx-sm-4 mt-3 mb-3">Customer Information </h1>
                    
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
                            <input type="radio" id="conPhone" name="contact" value="conPhone" <?php if(isset($_SESSION['contact']) && $_SESSION['contact'] =='conPhone' ){echo "checked";}?> checked>
                            <label for="conPhone">Phone</label>
                            <input type="radio" id="conEmail" name="contact" value="conEmail" <?php if(isset($_SESSION['contact']) && $_SESSION['contact'] =='conEmail' ){echo "checked";}?>>
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
                        <button type="submit" value="Next" name="Next" class="btn btn-success ">Next</button>
                        
                    </div>
                    </form>
                
            </div>
        </div>

<?php include('./common/footer.php'); ?>