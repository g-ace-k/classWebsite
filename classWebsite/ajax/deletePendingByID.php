<?php


session_start();
require_once(dirname(__FILE__) . "/../includes/RequireSSL.inc.php");
require_once(dirname(__FILE__) . "/../classes/dao/VeterinarianClinicDao.class.php");
require_once(dirname(__FILE__) . "/../includes/ReturnJSON.inc.php");

/*
 * ajax function that will delete a user from the database
 */

    $clinicID = $_POST['veterinarianId'];

    
    $response['querySuccess'] = VeterinarianClinicDao::Instance()->deletePendingByID($clinicID);
    
    print(json_encode($response));
    