<?php


session_start();
require_once(dirname(__FILE__) . "/../includes/RequireSSL.inc.php");
require_once(dirname(__FILE__) . "/../classes/dao/VeterinarianClinicDao.class.php");
require_once(dirname(__FILE__) . "/../includes/ReturnJSON.inc.php");

/*
 * ajax function that will delete a user from the database
 */

    $cName = $_POST['clinicName'];

    
    $response['querySuccess'] = VeterinarianClinicDao::Instance()->deleteClinicByName($cName);
    
    print(json_encode($response));
    