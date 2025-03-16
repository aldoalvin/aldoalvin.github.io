<?php
    session_start();
    $user = $_POST['username'];
    $pass = $_POST['password'];
    if(($user == 'admin') && ($pass == 'sjt697')){
        $_SESSION['username'] = $user;
        $_SESSION['password'] = $pass;
        header('location:dashboard.php');
    }else{
        header('location:adminlogin.php');
    }
?>