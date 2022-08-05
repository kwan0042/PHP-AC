<?php include("./common/header.php");
session_start(); 
$LogInVali = false;
$_SESSION["LogInVali"]=$LogInVali;
?>
    <div class="px-5 pt-4 pb-5">
        <h1>Welcome to Online Registration</h1>
        <p>If you have never used this before, you have to <a class="text-decoration-none" href="NewUser.php">Sign up</a> first.</p>
        <p>If you have already signed up, you can <a class="text-decoration-none" href="Login.php">Login in</a> now.</p>
    </div>
<?php include('./common/footer.php'); ?>

