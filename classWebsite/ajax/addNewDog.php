<?php

session_start();
require_once(dirname(__FILE__) . "/../includes/RequireSSL.inc.php");
require_once(dirname(__FILE__) . "/../classes/dao/DogDao.class.php");
require_once(dirname(__FILE__) . "/../includes/ReturnJSON.inc.php");
require_once(dirname(__FILE__) . "/../classes/services/DogService.class.php");

/*
 * ajax function that will add a dog into the database
 */
try {
    if (!empty($_POST['dogCert']) && !empty($_POST['dogChip']) && !empty($_POST['dogName']) && !empty($_POST['dogBreed']) && !empty($_POST['dogDate']) &&
            !empty($_POST['training'])) {
        $dogName = $_POST['dogName'];
        $dogCert = $_POST['dogCert'];
        $dogChip = $_POST['dogChip'];
        $dogDate = $_POST['dogDate'];
        $dogBreed = $_POST['dogBreed'];
        if (isset($_POST['comment'])) {
            $comment = $_POST['comment'];
        }
        $training = $_POST['training'];
        if(!empty($_POST['vetClinic'])){
            $vetClinic = "No Clinic Selected";
        }
        if (isset($_POST['vetClinic'])) {
            $vetClinic = $_POST['vetClinic'];
        }
        

        $dog = new Dog();
        $dog->dogName = $dogName;
        $dog->certNo = $dogCert;
        $dog->chipNo = $dogChip;
        $dog->breed = $dogBreed;
        $dog->notes = $comment;
        $dog->targetTrainingLevel = $training;

        $DOG = DogService::Instance()->checkDogBeforeAdding($dog, $vetClinic, $dogDate);
        $response['querySuccess'] = true;
        print(json_encode($response));
    } else {
        throw new Exception("Failed to add Dog testing service");
    }
} catch (Exception $e) {
    Website::handleError($e);
}