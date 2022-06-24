<!DOCTYPE html>
<!--
Click nbfs://nbhost/SystemFileSystem/Templates/Licenses/license-default.txt to change this license
Click nbfs://nbhost/SystemFileSystem/Templates/Scripting/EmptyPHPWebPage.php to edit this template
-->
<html>
    <head>
        <meta charset="UTF-8">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
        <title>Deposit Calculator Result</title>
    </head>
    <body>
        
        
    <?php
        
    if ($_SERVER['REQUEST_METHOD'] == 'POST'){
        $priAmount = trim($_POST["priAmount"]);
        $intRate = $_POST["intRate"]/100;
        $years = $_POST["years"];
        $name = $_POST["name"];
        $PosCode = $_POST["PosCode"];
        $phoNum = $_POST["phoNum"];
        $email = $_POST["email"];
        $contact = $_POST["contact"];
        $time = $_POST["time"];
        $inforY = $priAmount*$intRate;
        $errors = array();
        echo"<div class='mx-auto' style='margin-top: 20px;width: fit-content;'>";
        echo"<h2>Thank You $name, for using our deposit calculator!</h2>";
        
        
        
        
        if (is_numeric($priAmount)==null || $priAmount <0) {
                array_push($errors, 'The principal amount must be numeric and greater than 0');
        }
        if (is_numeric($_POST["intRate"])==null || $intRate <0) {
                array_push($errors, 'The Interest Rate(%) must be numeric and non-negative');
        }
        
        if (empty($priAmount)) {
            array_push($errors, 'The principal amount can not be Blank');
        }
        if (empty($intRate)) {
            array_push($errors, 'The Interest Rate(%) can not be Blank');
        }

        if (empty($name)) {
            array_push($errors, 'Name can not be blank');
        }

        if (empty($PosCode)) {
            array_push($errors, 'Postal code can not be blank');
        }
        if (empty($phoNum)) {
            array_push($errors, 'Phone number can not be Blank');
        }
        if (empty($email)) {
            array_push($errors, 'Email can not be Blank');
        }
        if ($_POST["contact"]==conPhone && $_POST["time"]==null) {
                array_push($errors, 'When preferred contact method is phone, you have to select one or more contact times');
        }

        if (!empty($errors)){
              echo"<p class='text-center'>However we can not process your request because of the following input error:</p>";
                    foreach ($errors as $error){
                    echo "<div class='d-flex flex-column'>";
                    echo "<li class='p-2'>$error</li>";
                    echo "\n";}
                    echo "</div>";
        }else {  
                if(count($_POST["time"])>1){
                    $secTime = "or <b> $time[1]</b>";
                }
                if ($_POST["contact"] == "conPhone"){
                    $pre = $phoNum;
                    echo"<p class='text-center'>Our customer service department will call you tomorrow <b>$time[0]</b> $secTime at <b>$pre</b>.</p>";
                }else{
                    $pre = $email;
                    echo"<p class='text-center'>Our customer service department will send you an email tomorrow at <b>$pre</b>.</p>";
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
                        $amountYrSt=$priAmount;
                        $in=$inforY;
                        while($y <= $years)
                            {
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
                                $y=$y+1;
                                $amountYrSt=$amountYrSt+$in;
                                $in=$amountYrSt*$intRate;
                            }

                echo"</tbody>";
                echo"</table>
                </div>";
                }
    }
    ?>
    </body>
</html>