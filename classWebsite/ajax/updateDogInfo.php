<?php

session_start();
//forces this to be sent over https
require_once(dirname(__FILE__) . "/../includes/RequireSSL.inc.php");

//changes the response type of the browser to JSON
require_once(dirname(__FILE__) . "/../includes/ReturnJSON.inc.php");
require_once(dirname(__FILE__) . "/../classes/dao/DogDao.class.php");

try {

    if (isset($_POST['dogId']) && isset($_POST['updatedDogName']) && isset($_POST['updatedBreed']) && isset($_POST['updatedTTL']) && isset($_POST['updatedVetClinic']) && isset($_POST['updatedNotes'])) {

        $dogId = $_POST['dogId'];
        $dogName = $_POST['updatedDogName'];
        $dogBreed = $_POST['updatedBreed'];
        $dogTTL = $_POST['updatedTTL'];
        $dogVetClinic = $_POST['updatedVetClinic'];
        $dogNotes = $_POST['updatedNotes'];

        $response["updated"] = DogDao::Instance()->updateDogInformation($dogId, $dogName, $dogBreed, $dogTTL, $dogNotes);
        print(json_encode($response));
    }
    if (isset($_POST['userSideDogId']) && isset($_POST['updatedUserSideDogName']) && isset($_POST['updatedUserSideDateOfBirth']) && isset($_POST['updatedUserSideBreed']) && isset($_POST['updatedUserSideTTL'])) {
        $dogId = $_POST['userSideDogId'];
        $dob = $_POST['updatedUserSideDateOfBirth'];
        $dogName = $_POST['updatedUserSideDogName'];
        $dogBreed = $_POST['updatedUserSideBreed'];
        $dogTTL = $_POST['updatedUserSideTTL'];
        $dog = new Dog();
        $dog->dateOfBirth = $dob;

        $response['updated'] = DogDao::Instance()->updateDog($dogName, $dog->dateOfBirth, $dogBreed, $dogTTL, $dogId);
        print(json_encode($response));
    }
} catch (Exception $e) {
    Website::handleError($e);
}