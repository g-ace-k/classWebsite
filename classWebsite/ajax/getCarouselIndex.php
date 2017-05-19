<?php

session_start();
require_once("../includes/RequireSSL.inc.php");
require_once("../includes/ReturnJSON.inc.php");

if (isset($_POST['key'])) {
    
    $key = $_POST['key'];
    print(json_encode($key));
    
}