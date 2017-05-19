<?php

session_start();
require_once("../includes/RequireSSL.inc.php");
require_once("../classes/dao/DogDao.class.php");
require_once("../includes/ReturnJSON.inc.php");
try {
    if (isset($_POST['dogId'])) {
        $dogId = $_POST['dogId'];

        $dog = DogDao::Instance()->getDogByDogId($dogId);
        print(json_encode($dog));
    }
} catch (Exception $e) {
    Website::handleError($e);
}

