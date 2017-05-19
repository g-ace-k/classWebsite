<?php

session_start();
require_once("../includes/RequireSSL.inc.php");
require_once("../classes/dao/DogDao.class.php");
require_once("../classes/services/DogService.class.php");
require_once("../includes/ReturnJSON.inc.php");

try {
        $dogs = DogService::Instance()->getAllInactiveDogUserAndClinic();
        if (count($dogs) >= 1) {
            print(json_encode($dogs));
        } else {
            throw new RuntimeException("No Inactive Dogs Found");
        }
} catch (RuntimeException $e) {
    Website::handleError($e);
}