<?php

session_start();
require_once("../includes/RequireSSL.inc.php");
require_once("../classes/dao/UserDao.class.php");
require_once("../includes/ReturnJSON.inc.php");

try {
    if (isset($_POST['firstName'])) {
        $name = $_POST['firstName'];
        $pieces = explode(" ", $name);
        if(count($pieces) == 1){
            $users = UserDao::Instance()->findUserByFirstName($name);
        }
        else if(count($pieces) > 1){
            $users = UserDao::Instance()->findUserByFullName($name);
        }
        if (count($users) >= 1) {
            print(json_encode($users));
        } else {
            throw new RuntimeException("No user Found");
        }
    }
} catch (RuntimeException $e) {
    Website::handleError($e);
}





