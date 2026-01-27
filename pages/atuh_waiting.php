<?php
session_start();

if (!isset($_SESSION['authorized'])) {
    header("Location: sign-in.php");
    exit;
}
