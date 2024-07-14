<?php
session_start();

if(isset($_SESSION["user"])){
    if($_SESSION['role'] == "admin"){
        header("Location: admin/index.php");
    }else{
        header("Location: user/index.php");
    }
}else{
    header("Location: login/login-user.php");
}