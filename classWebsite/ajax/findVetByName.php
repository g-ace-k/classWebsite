<?php

session_start();
require_once("../includes/RequireSSL.inc.php");
require_once("../classes/dao/VeterinarianClinicDao.class.php");
require_once("../includes/ReturnJSON.inc.php");


try {
    if (isset($_POST['clinicName'])) {
        $vetName = $_POST['clinicName'];
       if (!$vetName) {
            $vets = VeterinarianClinicDao::Instance()->getVeterinarianClinics();
        } else {
            $vets = VeterinarianClinicDao::Instance()->findVeterinarianClinicByName($vetName);
        }
        if (count($vets) >= 1) {
            print(json_encode($vets));
        } else {
            throw new RuntimeException("No clinics Found");
        }
    }
} catch (RuntimeException $e) {
    Website::handleError($e);
}





