<?php

session_start();
require_once(dirname(__FILE__) . "/../includes/RequireSSL.inc.php");
require_once(dirname(__FILE__) . "/../classes/dao/UserDao.class.php");
require_once(dirname(__FILE__) . "/../includes/ReturnJSON.inc.php");

/*
 * ajax function that will delete a user from the database
 */

    $userId = $_POST['userId'];

    $response['querySuccess'] = UserDao::Instance()->deleteUserById($userId);   
    
    print(json_encode($response));