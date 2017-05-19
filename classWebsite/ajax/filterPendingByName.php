<?php

session_start();
require_once("../includes/RequireSSL.inc.php");
require_once("../classes/dao/VeterinarianClinicDao.class.php");
require_once("../includes/ReturnJSON.inc.php");

try {
    if (isset($_POST['clinicName'])) {
        $clinicName = $_POST['clinicName'];
        $clinics = VeterinarianClinicDao::Instance()->findPendingVeterinarianClinicByName($clinicName);
        if (count($clinics) >= 1) {
            print(json_encode($clinics));
        } else {
            throw new RuntimeException("No clinics Found");
        }
    }
} catch (RuntimeException $e) {
    Website::handleError($e);
}


