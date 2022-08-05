<?php include("./common/header.php"); ?>


<?php
session_start(); 
$mypdo=parse_ini_file("lab6.ini");
extract($mypdo);
$pdo= new PDO($dsn, $user, $password);



$SIDErrData='';
$SIDErr = '';
$PasswordErr = '';

$StudentID = $_POST["StudentID"];
$Password = $_POST["Password"];


if(isset($_POST['submit'])){
    
    $SIDErr = ValidateStudentID($StudentID);
    $PasswordErr=ValidatePassword($Password);
    
    
    $sql1="SELECT * FROM `Student` WHERE StudentId =?";
    $stmt1= $pdo->prepare($sql1);
    $stmt1->bindValue('1', $StudentID);
    $stmt1->execute();
    $row = $stmt1->fetch(PDO::FETCH_ASSOC);
    if (password_verify($Password, $row[Password]))
    {
        $SIDErrData= '';
    }else{
        $SIDErrData= 'Incorrect student ID and/or Password !';
        
    }
    
    
    if( $SIDErr == ''&& 
        $PasswordErr==''&& 
        $SIDErrData==''){
        $_SESSION["LogInVali"] = true;
        $_SESSION["StudentID"] = $StudentID;
        $_SESSION["Password"] = $Password;
        
        header("Location: CourseSelection.php");
        exit();
    }
}else{
    if(isset($_SESSION["StudentID"]))
    {
        $StudentID = $_SESSION["StudentID"];
        $Password = $_SESSION["Password"];
    }
}



if(isset($_POST['clear'])) {
    $StudentID = '';
    $Password = '';
    $StudentidErr = '';
    $PasswordErr = '';
    }

function ValidateStudentID($StudentID){
    if(!isset($StudentID)|| strlen(trim($StudentID))==0){
            return 'Student ID is required';
        }else{
            return '';
        }
}

function ValidatePassword($Password){
    if(!isset($Password)||empty($Password)){
                return 'Password is required';
            }else{
                $Password=$_GET['Password'];
                return '';
            }
}


?>

<div class="px-5 pt-4 pb-5">
    <h1>Log In</h1>

    <p>You need to <a class="text-decoration-none" href="NewUser.php">Sign up</a> if you a new user.</p>

    <div class="mx-sm-0"><span class="error" style="color:red"><?php echo $SIDErrData;?></span></div>
    
    
    <form  method = "post" action="Login.php">
        <div class="form-group row">
            <label class="col-sm-2 col-form-label" for="StudentID">Student ID:</label>
            <div class="col-sm-3">
                <input type="text" name="StudentID" class="form-control"value="<?php echo $StudentID;?>">
            </div>
            
            <div class="col-sm-5">
                <span class="error" style="color:red"><?php echo $SIDErr;?></span>
            </div>
        </div>

        <div class="form-group row">
            <label class="col-sm-2 col-form-label" for="Password">Password:</label>
            <div class="col-sm-3">
                <input type="password" name="Password" class="form-control"value="<?php echo $Password;?>" onChange="<?php ValidatePassword($Password);?>">
            </div>
            <div class="col-sm-5">
                <span class="error" style="color:red"><?php echo $PasswordErr;?></span>
            </div>
        </div>

        <div class="form-group row justify-content-center pt-4">
            <div class="col-sm-8">
                <button type="submit" value="submit" name="submit" class="btn btn-success float-right">Submit</button>
                <button type="submit" name="clear" value="clear" class="btn btn-success">Clear</button>
            </div>
        </div>
    </form>
    
    
</div>

<?php include('./common/footer.php'); ?>