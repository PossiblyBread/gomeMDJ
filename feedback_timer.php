<?php
session_start(); 
if (isset($_POST['time_left'])) {
    $_SESSION['time_left'] = $_POST['time_left']; 
}
?>
