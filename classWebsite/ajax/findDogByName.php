<?php

session_start();
require_once("../includes/RequireSSL.inc.php");
require_once("../classes/dao/DogDao.class.php");
require_once("../classes/services/DogService.class.php");
require_once("../includes/ReturnJSON.inc.php");

try {
    if (isset($_POST['dogName'])) {
        $dogName = $_POST['dogName'];

        if (!$dogName) {
            $dogs = DogService::Instance()->getAllDogUserAndClinic();
        } else {
            $dogs = DogService::Instance()->getDogUserAndClinic($dogName);
        }
        if (count($dogs) >= 1) {
            print(json_encode($dogs));
        } else {
            throw new RuntimeException("No Dog Found");
        }
    }
} catch (RuntimeException $e) {
    Website::handleError($e);
}
