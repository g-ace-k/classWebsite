<?php
session_start();
require_once("../includes/RequireSSL.inc.php");
require_once("../includes/ReturnJSON.inc.php");
$_SESSION["user"] = null;

// remove all session variables
session_unset(); 

// destroy the session 
session_destroy(); 
