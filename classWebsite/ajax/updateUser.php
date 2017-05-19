<?php

session_start();
require_once(dirname(__FILE__) . "/../includes/RequireSSL.inc.php");
require_once(dirname(__FILE__) . "/../classes/dao/UserDao.class.php");
require_once(dirname(__FILE__) . "/../includes/ReturnJSON.inc.php");
//require_once(dirname(__FILE__) . "/../classes/services/UserService.class.php");

/*
 * ajax function that will update a user into the database
 */

try {
    if (isset($_POST['updatedFirstName']) && isset($_POST['updatedLastName']) && isset($_POST['updatedEmail']) &&
            isset($_POST['updatedStreetAddress']) && isset($_POST['updatedCity']) && isset($_POST['updatedState']) &&
            isset($_POST['updatedZipCode']) && isset($_POST['updatedPhoneNumber']) && isset($_POST['userId'])) 
        {
        $FirstName = $_POST['updatedFirstName'];
        $LastName = $_POST['updatedLastName'];
        if (isset($_POST['updatedMiddleInitial'])) {
            $MiddeInitial = $_POST['updatedMiddleInitial'];
        }
        $EmailAddress = $_POST['updatedEmail'];
        $StreetAddress = $_POST['updatedStreetAddress'];
        $City = $_POST['updatedCity'];
        $State = $_POST['updatedState'];
        $Zipcode = $_POST['updatedZipCode'];
        $PhoneNumber = $_POST['updatedPhoneNumber'];
        $UpdateId = $_POST['userId'];

        $response['updated'] = UserDao::Instance()->updateUser($FirstName, $LastName, $MiddeInitial, $EmailAddress, $StreetAddress, $City, $State, $Zipcode, $PhoneNumber, $UpdateId);
        print(json_encode($response));
    }
    if(isset($_POST['updatedUserSideFirstName']) && isset($_POST['updatedUserSideLastName']) && isset($_POST['updatedUserSideEmail']) &&
            isset($_POST['updatedUserSideStreetAddress']) && isset($_POST['updatedUserSideCity']) && isset($_POST['updatedUserSideState']) &&
            isset($_POST['updatedUserSideZipCode']) && isset($_POST['updatedUserSidePhoneNumber']) && isset($_POST['userSideUserId']))
    {
        $FirstName = $_POST['updatedUserSideFirstName'];
        $LastName = $_POST['updatedUserSideLastName'];
        if (isset($_POST['updatedUserSideMiddleInitial'])) {
            $MiddeInitial = $_POST['updatedUserSideMiddleInitial'];
        }
        $EmailAddress = $_POST['updatedUserSideEmail'];
        $StreetAddress = $_POST['updatedUserSideStreetAddress'];
        $City = $_POST['updatedUserSideCity'];
        $State = $_POST['updatedUserSideState'];
        $Zipcode = $_POST['updatedUserSideZipCode'];
        $PhoneNumber = $_POST['updatedUserSidePhoneNumber'];
        $UpdateId = $_POST['userSideUserId'];

        $response['updated'] = UserDao::Instance()->updateUser($FirstName, $LastName, $MiddeInitial, $EmailAddress, $StreetAddress, $City, $State, $Zipcode, $PhoneNumber, $UpdateId);
        print(json_encode($response));
    }
} catch (Exception $e) {
    Website::handleError($e);
}