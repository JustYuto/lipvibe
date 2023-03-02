<?php

    require_once('session.php');
    if(!isset($_SESSION['user'])){
        header('Location: login.php');
    }
?>