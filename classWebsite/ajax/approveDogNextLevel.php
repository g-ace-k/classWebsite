<?php


session_start();
//forces this to be sent over https
require_once("../includes/RequireSSL.inc.php");

//changes the response type of the browser to JSON
require_once("../includes/ReturnJSON.inc.php");


require_once(dirname(__FILE__) . "/../classes/services/DogService.class.php");
require_once(dirname(__FILE__) . "/../classes/exceptions/InvalidInputException.class.php");
require_once(dirname(__FILE__) . "/../classes/exceptions/AdminAccessException.class.php");

try {

    // checks to see if user is authenticated.  Similar to other file but throws an exception instead of forcing a redirect.
    require_once("../includes/CheckUserAuthenticatedWithoutRedirect.inc.php");

    if (isset($_POST['dogId'])) {
        if ($user->verifyAdmin()) {
            $dogId = $_POST['dogId'];
            $dog = DogDao::Instance()->getDogByDogId($dogId);
            
            $response["dog"] = $dog;
            $response["updated"] = true;
            print(json_encode(DogService::Instance()->approveDogNextLevel($dog)));
        } else {
            throw new AdminAccessException("updating dog level");
        }
    } else {
        throw new InvalidInputException("dogId is required");
    }
} catch (Exception $e) {
    Website::handleError($e);
}


