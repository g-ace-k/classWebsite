<?php

session_start();
require_once(dirname(__FILE__) . "/../includes/RequireSSL.inc.php");
require_once(dirname(__FILE__) . "/../classes/dao/UserDao.class.php");
require_once(dirname(__FILE__) . "/../includes/ReturnJSON.inc.php");
require_once(dirname(__FILE__) . "/../classes/services/UserService.class.php");

/*
 * ajax function that will add a user into the database
 */

    try {

        
        
        if (!empty($_POST['newUserName']) && !empty($_POST['newPassword']) && !empty($_POST['newFirstName']) &&
        !empty($_POST['newLastName']) && !empty($_POST['newEmailAddress']) && !empty($_POST['newStreetAddress'])
        && !empty($_POST['newCity']) && !empty($_POST['newState']) && !empty($_POST['newZipCode'])
        && !empty($_POST['newPhoneNumber']))
        {
            $newUserName = $_POST['newUserName'];
            $newPassword = $_POST['newPassword'];
            $newFirstName = $_POST['newFirstName'];
            if(isset($_POST['newMiddleInitial'])){
            $newMiddleInitial = $_POST['newMiddleInitial'];
            }
            $newLastName = $_POST['newLastName'];
            $newEmailAddress = $_POST['newEmailAddress'];
            $newStreetAddress = $_POST['newStreetAddress'];
            $newCity = $_POST['newCity'];
            $newState = $_POST['newState'];
            $newZipCode = $_POST['newZipCode'];
            $newPhoneNumber = $_POST['newPhoneNumber'];
            
            $user = new User();            
            $user->userName = $newUserName;
            $user->firstName = $newFirstName;
            $user->middleInitial = $newMiddleInitial;
            $user->lastName = $newLastName;
            $user->email = $newEmailAddress;
            $user->streetAddress = $newStreetAddress;
            $user->city = $newCity;
            $user->state = $newState;
            $user->zipCode = $newZipCode;
            $user->phoneNumber = $newPhoneNumber;

            $response['querySuccess'] = UserService::Instance()->addUser($user, $newPassword);
            print(json_encode($response));
        }
        else
        {
            throw new Exception("Failed to add User");
        }
    } catch (Exception $e) {
    Website::handleError($e);
}