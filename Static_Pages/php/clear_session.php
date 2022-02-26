<?php
    session_start();
    $_SESSION = array();
    setcookie("loginCookie","", time() - 1);
    header("Location: ../login.php");