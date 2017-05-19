<?php
session_start();
//forces this to be sent over https
require_once("../includes/RequireSSL.inc.php");

//changes the response type of the browser to JSON
require_once("../includes/ReturnJSON.inc.php");

require_once(dirname(__FILE__) . "/../classes/dao/DogDao.class.php");
require_once(dirname(__FILE__) . "/../classes/exceptions/InvalidInputException.class.php");

try {
    if (isset($_POST['dogId']) && isset($_POST['userId'])){
        $dogId = $_POST['dogId'];
        $userId = $_POST['userId'];
        
        $response['querySuccess'] = DogDao::Instance()->updateUserAssignedToDog($dogId, $userId);
        print(json_encode($response));
    } else {
        throw new InvalidInputException("Error Updating Handler");
    }
} catch (Exception $e) {
    Website::handleError($e);
}



