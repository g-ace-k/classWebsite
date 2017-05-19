<?php

session_start();
require_once(dirname(__FILE__) . "/../includes/RequireSSL.inc.php");
require_once(dirname(__FILE__) . "/../classes/dao/VeterinarianClinicDao.class.php");
require_once(dirname(__FILE__) . "/../classes/dao/DogDao.class.php");
require_once(dirname(__FILE__) . "/../includes/ReturnJSON.inc.php");
require_once(dirname(__FILE__) . "/../classes/services/UserService.class.php");



try {
    if (!empty($_POST['ClinicName']) && !empty($_POST['StreetAddress']) && !empty($_POST['City']) && !empty($_POST['State']) && !empty($_POST['Zipcode']) && !empty($_POST['PhoneNumber'])) {
        if (isset($_POST['ClinicName']) && isset($_POST['StreetAddress']) &&
                isset($_POST['City']) && isset($_POST['State']) && isset($_POST['Zipcode']) && isset($_POST['PhoneNumber']) && strlen($_POST['Zipcode'])==5)
        // $vetsCompare = VeterinarianClinicDao::Instance()->getVeterinarianClinics();
            $vetsCompare = VeterinarianClinicDao::Instance()->clinicValidationByZip($_POST['Zipcode']);
        $ClinicExists = false;

        //if in new zip code, create clinic
        if (count($vetsCompare) < 1) {
            $ClinicExists = false;
        } else {
            //check for name
            foreach ($vetsCompare as $vets) {
                if ($vets->clinicName === $_POST['ClinicName']) {
                    $ClinicExists = true;
                    $dogid = $_POST['DogID'];
                    $response['querySuccess'] = DogDao::Instance()->updateDogVetId($dogid, $vets->veterinarianId);
                    print(json_encode($response));
                }
            }
        }
        if (!$ClinicExists) {
            $ClinicName = $_POST['ClinicName'];
            $Zipcode = $_POST['Zipcode'];
            $City = $_POST['City'];
            $StreetAddress = $_POST['StreetAddress'];
            $State = $_POST['State'];
            $PhoneNumber = $_POST['PhoneNumber'];
            $response['querySuccess'] = VeterinarianClinicDao::Instance()->userToPending($ClinicName, $StreetAddress, $State, $City, $Zipcode, $PhoneNumber);
            print(json_encode($response));
        }
    }
} catch (Exception $e) {
    Website::handleError($e);
}