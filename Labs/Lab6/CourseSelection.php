<?php
session_start(); 	
$mypdo=parse_ini_file("lab6.ini");
extract($mypdo);
$pdo= new PDO($dsn, $user, $password);

$sql1="SELECT * FROM `Student` WHERE StudentId =?";
$stmt1= $pdo->prepare($sql1);
$stmt1->bindValue('1', $_SESSION["StudentID"]);
$stmt1->execute();
$row = $stmt1->fetch(PDO::FETCH_ASSOC);
if($_SESSION["Name"] ==""){
    $_SESSION["Name"]=$row["Name"];
}


if (!isset($_SESSION["LogInVali"]))
{
    header("Location: Login.php");
    exit( );
}

////////////////////////////////////////////////////////////////////////////////////

if(!isset($_SESSION["Sem"])){
    $Sem="01";
    $_SESSION["Sem"]=$Sem;
    
}

if(isset($_POST['Sem'])){
        $_SESSION["Sem"] = $_POST['Sem'];
        $Sem=$_SESSION["Sem"];
        $sqlhr = "SELECT SUM(WeeklyHours) FROM `Registration` INNER JOIN `Course` ON Registration.CourseCode=Course.CourseCode WHERE StudentId =? && SemesterCode =?";
        $stmtS = $pdo->prepare($sqlhr);
        $stmtS->bindValue('1', $_SESSION["StudentID"]);
        $stmtS->bindValue('2', $Sem);
        $stmtS->execute();
        $rowS = $stmtS->fetch(PDO::FETCH_ASSOC);
        $RegHr=$rowS['SUM(WeeklyHours)'];
        
       if($RegHr==null){
            $RegHr=0;
        }else{
            $RegHr=$rowS['SUM(WeeklyHours)'];
        }
        
   }

if($RegHr==null){
            $RegHr=0;
        }else{
            $RegHr=$rowS['SUM(WeeklyHours)'];
        }

$sqlhr = "SELECT SUM(WeeklyHours) FROM `Registration` INNER JOIN `Course` ON Registration.CourseCode=Course.CourseCode WHERE StudentId =? && SemesterCode =?";
$stmtS= $pdo->prepare($sqlhr);
$stmtS->bindValue('1', $_SESSION["StudentID"]);
$stmtS->bindValue('2', $_SESSION["Sem"]);
$stmtS->execute();
$rowS = $stmtS->fetch(PDO::FETCH_ASSOC);
$RegHr=$rowS['SUM(WeeklyHours)'];
if($RegHr==null){
    $RegHr=0;
}else{
    $RegHr=$rowS['SUM(WeeklyHours)'];
    }
        
$TotalHr=16;
$LeftHr=$TotalHr-$RegHr;
   

$SCourseErr='';
$CourseHrErr='';
$SCourseList = $_POST["Course"];
$SID=$_SESSION["StudentID"];
$Sem =$_SESSION["Sem"];


if(isset($_POST["submit"])){
    
    
    $SCourseErr=ValidateSCourse($SCourseList);
    $CourseHrErr=ValidateCourseHr($SCourseList,$RegHr,$TotalHr,$pdo);
    
    if($SCourseErr=='' && $CourseHrErr==''){
        
        $_SESSION["Course"] = $_POST["Course"];
        
        foreach ($SCourseList as $SCourse) {
            $sql = "INSERT INTO Registration(StudentId, CourseCode, SemesterCode) VALUES (?, ?, ?)";
            $stmt= $pdo->prepare($sql);
            $stmt->bindParam(1,$_SESSION["StudentID"]);
            $stmt->bindParam(2,$SCourse);
            $stmt->bindParam(3,$Sem);
            $stmt->execute();
            }
            
        $sqlhr = "SELECT SUM(WeeklyHours) FROM `Registration` INNER JOIN `Course` ON Registration.CourseCode=Course.CourseCode WHERE StudentId =? && SemesterCode =?";
        $stmtS= $pdo->prepare($sqlhr);
        $stmtS->bindValue('1', $_SESSION["StudentID"]);
        $stmtS->bindValue('2', $Sem);
        $stmtS->execute();
        $rowS = $stmtS->fetch(PDO::FETCH_ASSOC);
        $RegHr=$rowS['SUM(WeeklyHours)'];
        
        $LeftHr=$TotalHr-$RegHr;
        $_SESSION["Sem"]=$Sem;
        
    }else{
        if(isset($_SESSION["Name"]))
        {
            
            $SavedCourse = $_POST["Course"];
            $RegHr=$rowS['SUM(WeeklyHours)'];
            if($RegHr==null){
            $RegHr=0;
            }
        
        }
            
        
    }
}
    
   

function ValidateSCourse($SCourseList){
    if($SCourseList==null){
        return 'You need select at least one course!';
    }else{
        return '';
    }
}

function ValidateCourseHr($SCourseList,$RegHr,$TotalHr,$pdo){
    $Chr=array();
    foreach ($SCourseList as $SCourse){
        $sqlChr = "SELECT WeeklyHours FROM `Course` WHERE CourseCode =?"; 
        $stmtChr= $pdo->prepare($sqlChr);
        $stmtChr->bindParam('1',$SCourse);
        $stmtChr->execute();
        $rowChr = $stmtChr->fetch(PDO::FETCH_ASSOC);
        $Chr[]=$rowChr['WeeklyHours'];
        
    }
    $Sumchr=array_sum($Chr);
    if(($Sumchr+$RegHr)>$TotalHr){
        return 'Your Selection exceed the max weekly hours';
        
    }else{
        return '';
    }
}


include("./common/header.php"); 
?>



<div class="px-5 pt-4 pb-5">
    <h1>Course Selection</h1>

    <p>Welcome <b><?php echo $_SESSION["Name"]?></b> (not you? change user <a class="text-decoration-none" href="Logout.php">here</a>)</p>
    <p>You have registered <b><?php echo $RegHr,$Sumchr?></b> hours for the selected semester.</p>
    <p>You can register <b><?php echo $LeftHr?></b> more hours of course(s) for the semester.</p>
    <p>Please note that the courses you have registered will not be displayed in the list.</p>
    
    <form method = "post" action="CourseSelection.php">
        
        <select class="form-select form-select-sm mb-2" name="Sem" onchange="this.form.submit()">
        <?php
            $sql3="SELECT * FROM `Semester`";
            $stmt3= $pdo->prepare($sql3);
            $stmt3->execute();
            $srows = array();
            while($srow = $stmt3->fetch(PDO::FETCH_ASSOC))
                $srows[] = $srow;
                
            foreach($srows as $srow){ 
                echo "<option value=\"".$srow['SemesterCode']."\"";
                if($_SESSION["Sem"] == $srow['SemesterCode'])
                      echo 'selected';
                echo ">".$srow['Year']." ".$srow['Term']."</option>";
            }
             
        ?>
        </select>
        
    </form>
    <form  method = "post" action="CourseSelection.php">
        <span id="Stext1" class="error" style="color:red"><?php echo $SCourseErr;?></span>
        <span id="Stext2" class="error" style="color:red"><?php echo $CourseHrErr;?></span>
        <table class="table">
            <tr><th>Code</th><th>Course Title</th><th>Hours</th><th>Select</th></tr>
            <?php
                
                
                $sql4="SELECT * FROM `CourseOffer` 
                    INNER JOIN `Course` ON CourseOffer.CourseCode=Course.CourseCode 
                    INNER JOIN `Semester` ON CourseOffer.SemesterCode=Semester.SemesterCode
                    WHERE CourseOffer.SemesterCode =? && CourseOffer.CourseCode NOT IN (SELECT CourseCode FROM `Registration`)";
                $stmt4= $pdo->prepare($sql4);
                $stmt4->bindValue('1', $Sem);
                $stmt4->execute();
                while($orow = $stmt4->fetch(PDO::FETCH_ASSOC))
                    $orows[] = $orow;
                foreach($orows as $orow){ 
                    
                        echo "<tr><td>".$orow['CourseCode']."</td><td>".$orow['Title']."</td><td>".$orow['WeeklyHours']."</td><td><input type='checkbox' onclick='checkFluency()' id='course' name='Course[]' value='".$orow['CourseCode']."'";
                                if (in_array($orow['CourseCode'], $SavedCourse)) echo "checked='checked'";
                        echo "></td></tr>";
                    }
                    
                    
            ?>
        </table>
        <div class="form-group row justify-content-center pt-3">
            <div>
                <button type="submit" value="submit" name="submit" class="btn btn-success float-right">Submit</button>
                <button type="submit" name="clear" value="clear" class="btn btn-success">Clear</button>
            </div>
        </div>
    </form>
</div>


<script type="text/JavaScript">
function checkFluency()
{
  var checkbox = document.getElementById('course');
  
  if (checkbox.checked == true)
  {

    document.getElementById("Stext1").style.display = "none";
    
  }
  if (checkbox.checked != true)
  {

    document.getElementById("Stext2").style.display = "none";
    
  }
}
</script>







<?php include('./common/footer.php');?>