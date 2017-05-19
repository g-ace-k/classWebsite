<?php

session_start();
require_once("../includes/RequireSSL.inc.php");
require_once("../classes/dao/UserDao.class.php");
require_once("../includes/ReturnJSON.inc.php");

try {
    if (isset($_POST['firstName'])) {
        $name = $_POST['firstName'];
        $users = UserDao::Instance()->findUserByName($name);
        if (count($users) >= 1) {
            print(json_encode($users));
        } else {
            throw new RuntimeException("No User Found");
        }
    }
} catch (RuntimeException $e) {
    Website::handleError($e);
}