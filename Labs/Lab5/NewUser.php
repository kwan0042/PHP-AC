<?php 
session_start(); 
$pdo = require 'connect.php';

$SIDErr = '';
$NameErr = '';
$phoNumErr = '';
$PasswordErr = '';
$RPasswordErr ='';
$SIDErrData='';



$StudentID = $_POST["StudentID"];
$Name = $_POST["Name"];
$phoNum = $_POST["phoNum"];
$Password = $_POST["Password"];
$RPassword = $_POST["RPassword"];


    


if(isset($_POST['submit'])){
    $SIDErr = ValidateStudentID($StudentID);
    $NameErr = ValidateName($Name);
    $phoNumErr = ValidatephoNum($phoNum);
    $PasswordErr = ValidatePassword($Password);
    $RPasswordErr = ValidateRPassword($Password,$RPassword);

    $sql1="SELECT COUNT(*) AS num FROM `Student` WHERE StudentId =:StudentId";
    $stmt1= $pdo->prepare($sql1);
    $stmt1->bindValue(':StudentId', $StudentID);
    $stmt1->execute();
    $row = $stmt1->fetch(PDO::FETCH_ASSOC);
    if ($row['num'] > 0)
    {
        $SIDErrData= 'A student with this ID has already siged up';
    }else{
        $SIDErrData= '';
    }

    if( $SIDErr == ''&&
        $NameErr == ''&&
        $phoNumErr == ''&&
        $PasswordErr == ''&&
        $RPasswordErr ==''&&
        $SIDErrData ==''){

        $_SESSION["StudentID"] = $StudentID;
        $_SESSION["Name"] = $Name;
        $_SESSION["phoNum"] = $phoNum;
        $_SESSION["Password"] = $Password;
        $_SESSION["RPassword"] = $RPassword;

        
        $data = [
            'StudentId' => $StudentID,
            'Name' => $Name,
            'Phone' => $phoNum,
            'Password'=>$Password
        ];
        $sql = "INSERT INTO Student(StudentId, Name, Phone, Password) VALUES (:StudentId, :Name, :Phone, :Password)";
        $stmt= $pdo->prepare($sql);
        $stmt->execute($data);
        
        $_SESSION["LogInVali"]=true;
        
        header("Location: CourseSelection.php");
        exit();
    }

}else{
    if(isset($_SESSION["StudentID"]))
    {
        $StudentID = $_SESSION["StudentID"];
        $Name = $_SESSION["Name"];
        $phoNum =  $_SESSION["phoNum"];
        $Password = $_SESSION["Password"];
        $RPassword = $_SESSION["RPassword"];
    }
}

if(isset($_POST['clear'])) {
    $StudentID = '';
    $Name = '';
    $phoNum = '';
    $Password = '';
    $RPassword = '';
    $StudentidErr = '';
    $NameErr = '';
    $phoNumErr = '';
    $PasswordErr = '';
    $RPasswordErr ='';
}

function ValidateStudentID($StudentID){
    if(!isset($StudentID)|| strlen(trim($StudentID))==0)
    {
        return 'Student ID is required';
    }else{
        return '';
    }
    
    
}
function ValidateName($Name){
    if((!isset($Name))||(strlen(trim($Name))==0)){

        return 'Name is required';

    }else{
        return '';
    }
}
function ValidatephoNum($phoNum){
    if((!isset($phoNum))||(empty($phoNum))){
                return 'Phone number is required';
            }
            if(!preg_match("/^[2-9]{1}[0-9]{2}-[2-9]{1}[0-9]{2}-[0-9]{4}$/i",$phoNum)){
                return 'Incorrect phone number';
            }else{
                return '';
            }
}
function ValidatePassword($Password){
    
    $uppercase = preg_match('@[A-Z]@', $Password);
    $lowercase = preg_match('@[a-z]@', $Password);
    $number    = preg_match('@[0-9]@', $Password);
    if(!isset($Password)||empty($Password)||!$uppercase||!$lowercase||!$number){
                return 'Password is at least 6 characters long, contains at least one upper case, one lowercase and one digit.';
            
            }else{
                return '';
            }
    
}
function ValidateRPassword($Password,$RPassword){
    if($RPassword != $Password){
        return 'Password is not equal.';
    }else{
        return '';
    }
}


include("./common/header.php"); 
?>

<div class="px-5 pt-4 pb-5">
    <h1>Sign Up</h1>

    <p>All fields are required</p>
    
    
    <form  method = "post" action="NewUser.php">
        <div class="form-group row pt-3">
            <label class="col-sm-2 col-form-label" for="StudentID">Student ID:</label>
            <div class="col-sm-3">
                <input type="text" name="StudentID" class="form-control"value="<?php echo $StudentID;?>">
            </div>
            
            <div class="col-sm-5">
                <span class="error" style="color:red"><?php echo $SIDErr.$SIDErrData;?></span>
            </div>
        </div>

        <div class="form-group row pt-3">
            <label class="col-sm-2 col-form-label" for="Name">Name:</label>
            <div class="col-sm-3">
                <input type="text" name="Name" class="form-control"value="<?php echo $Name;?>">
            </div>
            <div class="col-sm-5">
                <span class="error" style="color:red"><?php echo $NameErr;?></span>
            </div>
        </div>
        
        <div class="form-group row pt-3">
            <label class="col-sm-2 col-form-label" for="phoNum">Phone Number:<br>(nnn-nnn-nnnn)</label>
            <div class="col-sm-3">
                <input type="text" name="phoNum" class="form-control"value="<?php echo $phoNum;?>">
            </div>
            <div class="col-sm-5">
                <span class="error" style="color:red"><?php echo $phoNumErr;?></span>
            </div>
        </div>
        
        <div class="form-group row ">
            <label class="col-sm-2 col-form-label" for="Password">Password:</label>
            <div class="col-sm-3">
                <input type="password" name="Password" class="form-control"value="<?php echo $Password;?>">
            </div>
            <div class="col-sm-5">
                <span class="error" style="color:red"><?php echo $PasswordErr;?></span>
            </div>
        </div>
        
        <div class="form-group row pt-3">
            <label class="col-sm-2 col-form-label" for="RPassword">Password Again:</label>
            <div class="col-sm-3">
                <input type="password" name="RPassword" class="form-control"value="<?php echo $RPassword;?>">
            </div>
            <div class="col-sm-6">
                <span class="error" style="color:red"><?php echo $RPasswordErr;?></span>
            </div>
        </div>

        
        
        <div class="form-group row justify-content-center pt-3">
            <div class="col-sm-8">
                <button type="submit" value="submit" name="submit" class="btn btn-success float-right">Submit</button>
                <button type="submit" name="clear" value="clear" class="btn btn-success">Clear</button>
            </div>
        </div>
    </form>
    
</div>

<?php include('./common/footer.php'); ?>