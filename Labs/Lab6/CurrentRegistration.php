<?php 
session_start(); 
$mypdo=parse_ini_file("lab6.ini");
extract($mypdo);
$pdo= new PDO($dsn, $user, $password);
				
if (!isset($_SESSION["LogInVali"]))
{
    header("Location: Login.php");
    exit( );
}



$SCourseList = $_POST["Course"];

if(isset($_POST["submit"])){
    
    foreach ($SCourseList as $DelCour){
    $sqlDel = "DELETE FROM Registration WHERE StudentId=? && CourseCode=?";
    $stmtDel= $pdo->prepare($sqlDel);
    $stmtDel->bindValue('1', $_SESSION["StudentID"]);
    $stmtDel->bindValue('2', $DelCour);
    $stmtDel->execute();
    }
    
    
}

include("./common/header.php"); ?>


<div class="px-5 pt-4 pb-5">
    <h1>Current Registrations</h1>

    <p>Hello <b><?php echo $_SESSION["Name"]?></b> (not you? change user <a class="text-decoration-none" href="Logout.php">here</a>), the followings are your current registrations.</p>
    
<form  method = "post" action="CurrentRegistration.php">
        <table class="table">
            <tr><th>Year</th><th>Term</th><th>Course Code</th><th>Course Title</th><th>Hours</th><th>Select</th></tr>
            <?php
                $sqlA="SELECT * FROM `Registration` 
                    INNER JOIN `Course` ON Registration.CourseCode=Course.CourseCode 
                    INNER JOIN `Semester` ON Registration.SemesterCode=Semester.SemesterCode
                    WHERE StudentId =? && Registration.SemesterCode=01";
                $stmtA= $pdo->prepare($sqlA);
                $stmtA->bindValue('1', $_SESSION["StudentID"]);
                $stmtA->execute();
                while($Arow = $stmtA->fetch(PDO::FETCH_ASSOC))
                    $Arows[] = $Arow;
                
                foreach($Arows as $Arow){ 
                    
                        echo "<tr><td>".$Arow['Year']."</td><td>".$Arow['Term']."</td><td>".$Arow['CourseCode']."</td><td>".$Arow['Title']."</td><td>".$Arow['WeeklyHours']."</td><td><input type='checkbox' name='Course[]' value='".$Arow['CourseCode']."'";
//                                if(in_array($Arow['CourseCode'], $SavedCourse)) echo "checked='checked'";
                        echo "></td></tr>";
                    }
                $sqlTHr = "SELECT SUM(WeeklyHours) FROM `Registration` INNER JOIN `Course` ON Registration.CourseCode=Course.CourseCode WHERE StudentId =? && Registration.SemesterCode=01";
                $stmtTHr= $pdo->prepare($sqlTHr);
                $stmtTHr->bindValue('1', $_SESSION["StudentID"]);
                $stmtTHr->execute();
                $rowTHr = $stmtTHr->fetch(PDO::FETCH_ASSOC);
                $SemTHr=$rowTHr['SUM(WeeklyHours)'];
                if($SemTHr>1){
                    echo "<tr><td></td><td></td><td></td><td style='text-align: right;'>Total Weekly Hours</td><td>".$SemTHr."</td><td></td></tr><tr><td></td><td></td><td></td><td></td><td></td><td></td></tr>";
                }
                
                
                
                ////////////////////////////////////////
                
                
                
                
                $sqlB="SELECT * FROM `Registration` 
                    INNER JOIN `Course` ON Registration.CourseCode=Course.CourseCode 
                    INNER JOIN `Semester` ON Registration.SemesterCode=Semester.SemesterCode
                    WHERE StudentId =? && Registration.SemesterCode=02";
                $stmtB= $pdo->prepare($sqlB);
                $stmtB->bindValue('1', $_SESSION["StudentID"]);
                $stmtB->execute();
                while($Brow = $stmtB->fetch(PDO::FETCH_ASSOC))
                    $Brows[] = $Brow;
                
                foreach($Brows as $Brow){ 
                    
                        echo "<tr><td>".$Brow['Year']."</td><td>".$Brow['Term']."</td><td>".$Brow['CourseCode']."</td><td>".$Brow['Title']."</td><td>".$Brow['WeeklyHours']."</td><td><input type='checkbox' name='Course[]' value='".$Brow['CourseCode']."'";
//                                if(in_array($Arow['CourseCode'], $SavedCourse)) echo "checked='checked'";
                        echo "></td></tr>";
                    }
                $sqlTHr1 = "SELECT SUM(WeeklyHours) FROM `Registration` INNER JOIN `Course` ON Registration.CourseCode=Course.CourseCode WHERE StudentId =? && Registration.SemesterCode=02";
                $stmtTHr1= $pdo->prepare($sqlTHr1);
                $stmtTHr1->bindValue('1', $_SESSION["StudentID"]);
                $stmtTHr1->execute();
                $rowTHr1 = $stmtTHr1->fetch(PDO::FETCH_ASSOC);
                $SemTHr1=$rowTHr1['SUM(WeeklyHours)'];
                if($SemTHr1>1){
                    echo "<tr><td></td><td></td><td></td><td style='text-align: right;'>Total Weekly Hours</td><td>".$SemTHr1."</td><td></td></tr><tr><td></td><td></td><td></td><td></td><td></td><td></td></tr>";
                }
                
                
                
                ////////////////////////////////////////
                
                
                
                $sqlC="SELECT * FROM `Registration` 
                    INNER JOIN `Course` ON Registration.CourseCode=Course.CourseCode 
                    INNER JOIN `Semester` ON Registration.SemesterCode=Semester.SemesterCode
                    WHERE StudentId =? && Registration.SemesterCode=03";
                $stmtC= $pdo->prepare($sqlC);
                $stmtC->bindValue('1', $_SESSION["StudentID"]);
                $stmtC->execute();
                while($Crow = $stmtC->fetch(PDO::FETCH_ASSOC))
                    $Crows[] = $Crow;
                
                foreach($Crows as $Crow){ 
                    
                        echo "<tr><td>".$Crow['Year']."</td><td>".$Crow['Term']."</td><td>".$Crow['CourseCode']."</td><td>".$Crow['Title']."</td><td>".$Crow['WeeklyHours']."</td><td><input type='checkbox' name='Course[]' value='".$Crow['CourseCode']."'";
//                                if(in_array($Arow['CourseCode'], $SavedCourse)) echo "checked='checked'";
                        echo "></td></tr>";
                    }
                $sqlTHr2 = "SELECT SUM(WeeklyHours) FROM `Registration` INNER JOIN `Course` ON Registration.CourseCode=Course.CourseCode WHERE StudentId =? && Registration.SemesterCode=03";
                $stmtTHr2= $pdo->prepare($sqlTHr2);
                $stmtTHr2->bindValue('1', $_SESSION["StudentID"]);
                $stmtTHr2->execute();
                $rowTHr2 = $stmtTHr2->fetch(PDO::FETCH_ASSOC);
                $SemTHr2=$rowTHr2['SUM(WeeklyHours)'];
                if($SemTHr2>1){    
                    echo "<tr><td></td><td></td><td></td><td style='text-align: right;'>Total Weekly Hours</td><td>".$SemTHr2."</td><td></td></tr><tr><td></td><td></td><td></td><td></td><td></td><td></td></tr>";
                }
            ?>
        </table>
        <div class="form-group row justify-content-center pt-3">
            <div>
                <button type="submit" value="submit" name="submit" class="btn btn-success float-right" onclick="return confirm('The selected regustrations will be delected')">Delete Selected</button>
                <button type="submit" value="clear" name="clear" class="btn btn-success">Clear</button>
            </div>
        </div>
    </form>
</div>

<?php include('./common/footer.php'); ?>