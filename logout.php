<?php
session_start();

if (isset($_SESSION['logged_in'])) {
    $_SESSION = [];
    $_SESSION['success_message'] = 'You are logged out, see you next time :)';
    header('location: index.php');
    die();
}