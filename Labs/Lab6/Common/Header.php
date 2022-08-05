<!DOCTYPE html>
<!--
Click nbfs://nbhost/SystemFileSystem/Templates/Licenses/license-default.txt to change this license
Click nbfs://nbhost/SystemFileSystem/Templates/Scripting/EmptyPHPWebPage.php to edit this template
-->
<html>
    <head>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script><meta charset="UTF-8">
        <title></title>
    </head>
    <body style="margin-bottom: 100px">
        <header>
            <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
                    <div class="navbar-nav px-2 ">
                        <a class="navbar-brand" href="http://www.algonquincollege.com"><img src="Common/img/ACLogo.png" width="40" height="30"></a>
                        <a class="nav-item nav-link" href="Index.php">Home</a>
                        <a class="nav-item nav-link" href="CourseSelection.php">Course Selection</a>
                        <a class="nav-item nav-link" href="CurrentRegistration.php">Current Registration</a>
                        <?php 
                        session_start(); 
                        
                        if (!isset($_SESSION["LogInVali"]))
                        {
                            echo'<a class="nav-item nav-link" href="Login.php">Log In</a>';
                        }if($_SESSION["LogInVali"]==true){
                            echo'<a class="nav-item nav-link" href="Logout.php">Log Out</a>';
                        }
                        
                        ?>
                        
                    </div>
            </nav>
        </header>
        
        
        
