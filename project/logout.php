<?php
session_start();
unset($_SESSION['user_id']);
unset($_SESSION['user_firstname']);
unset($_SESSION['user_fullname']);
unset($_SESSION['user_role']);
header("Location: login.php");
